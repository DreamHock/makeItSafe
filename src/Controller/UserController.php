<?php

namespace App\Controller;

use App\Entity\Language;
use App\Entity\Role;
use App\Entity\TechnicalRole;
use App\Entity\User;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api')]
class UserController extends AbstractController

{
    public $entityManager;
    public $normalizer;
    public $validator;
    public function __construct(EntityManagerInterface $entityManager, NormalizerInterface $normalizer, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->normalizer = $normalizer;
        $this->validator = $validator;
    }

    public function customNormalizer($object)
    {
        return $this->normalizer->normalize($object, 'It doesn`t matter', [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($obj) {
                return $obj->getId();
            }
        ]);
    }

    #[Route('/users/current-user', name: 'app_user', methods: ['get'])]
    public function currentUser(#[CurrentUser()] ?User $user): Response
    {
        return $this->json([
            "id" => $user->getId(),
            "firstName" => $user->getFirstName(),
            "lastName" => $user->getLastName(),
            "email" => $user->getEmail(),
        ]);
    }

    #[Route('/users/users-current-organization', name: "users_current_organization", methods: ["get"])]
    #[IsGranted('ROLE_ADMIN', message: "the authenticated user is not an admin")]
    public function usersCurrentUser(#[CurrentUser()] ?User $user): Response
    {
        $conn = $this->entityManager->getConnection();
        $organizationUsers = $conn->executeQuery('SELECT id, first_name, last_name, email, roles from user where organization_id=' . $user->getOrganization()->getId())->fetchAllAssociative();
        $normalUsers = array();
        foreach ($organizationUsers as $user) {
            $decoded = json_decode($user['roles']);
            if (!in_array("ROLE_ADMIN", $decoded)) {
                $normalUsers[] = $user;
            }
        };

        return $this->json($normalUsers);
    }

    #[Route('/users', name: "user_store", methods: ["post"])]
    #[IsGranted('ROLE_ADMIN', message: "the authenticated user is not an admin")]
    public function store(Request $request, #[CurrentUser()] ?User $currentUser)
    {
        $decoded = json_decode($request->getContent());
        $user = new User();
        $organization = $currentUser->getOrganization();
        $user->setOrganization($organization);
        $user->setFirstName($decoded->contact->firstName);
        $user->setLastName($decoded->contact->lastName);
        $user->setPhone($decoded->contact->phone);
        $user->setAddress($decoded->contact->useOrganizationAddress ? $decoded->contact->organizationAddress : $decoded->contact->address);
        $user->setFunction($decoded->contact->func);
        $user->setContactEmail($decoded->contact->email);
        $user->setEmail($decoded->user->email);
        $user->setHasInvitation($decoded->user->confirmInvitation);
        $user->setEmail($decoded->user->email);
        $user->setHasNotifications(!$decoded->user->enableNotifications);
        $user->setEndValidationAt(Carbon::parse($decoded->user->endValidationAt)->toImmutable());
        $user->setEndDemoAt(Carbon::parse($decoded->user->endDemoAt)->toImmutable());
        $language = $this->entityManager->getRepository(Language::class)->find($decoded->user->language);
        $user->setLanguage($language);

        $errors = $this->validator->validate($user);

        $roles = array();
        foreach ($decoded->user->technicalRoles as $key => $value) {
            if ($value == true && in_array($key, ["ROLE_ADMIN", "ROLE_USER", "ROLE_INTERVIEW"])) {
                $roles[] = $key;
            }
        }
        if (count($roles) > 0) {
            $user->setRoles($roles);
            foreach ($roles as $role) {
                $roleObject = $this->entityManager->getRepository(TechnicalRole::class)->findBy(['name' => $role]);
                $user->addTechnicalRole($roleObject);
            }
        } else {
            $technicalRolesConstraint = new ConstraintViolation('chose one or multiple roles', null, [], $user, 'technicalRole', 'invalid_value');
            $errors->add($technicalRolesConstraint);
        }

        if ($decoded->user->role != "" && in_array($decoded->user->role, ["administrateur", "commanditaire", "auditeur", "audité"])) {
            $roles[] = $decoded->user->role;
            $roleObject = $this->entityManager->getRepository(Role::class)->findBy(['name' => $decoded->user->role]);
            $user->setRole($roleObject);
        } else {
            $roleConstraint = new ConstraintViolation('chose one of the roles', null, [], $user, 'role', 'invalid_value');
            $errors->add($roleConstraint);
        }

        if (count($errors) > 0) {
            return $this->json($errors);
        }
        $language->addUser($user);
        $this->entityManager->beginTransaction();
        try {
            // Persist the entity
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            // Commit the transaction
            $this->entityManager->commit();
            return $this->json(['message' => 'User created successfully'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            // Rollback the transaction on error
            $this->entityManager->rollback();

            return $this->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[IsGranted('ROLE_ADMIN', message: "the authenticated user is not an admin")]
    #[Route('/users/{id}', methods: ["DELETE"])]
    function delete($id)
    {
        $product = $this->entityManager->getRepository(User::class)->find($id);
        $email = $product->getEmail();
        if (in_array("ROLE_ADMIN", $product->getRoles())) {
            return $this->json(["message" => "you are not authorized to delete an admin"]);
        }
        $this->entityManager->remove($product);
        $this->entityManager->flush();
        return $this->json(["message" => "the user with the email " . $email . " has been deleted"]);
    }

    #[Route('/roles/{organizationId}', methods: ["GET"])]
    function findRolesByOrganization($organizationId)
    {
        $rolesByOrganization = $this->entityManager->createQuery(
            'SELECT r.id, r.name from App\Entity\User u join u.role r join u.organization o where o.id = :organizationId'
        )
            ->setParameter('organizationId', $organizationId)
            ->getResult();
        return $this->json($rolesByOrganization);
    }
}
