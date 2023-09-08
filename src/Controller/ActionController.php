<?php

namespace App\Controller;

use App\Entity\Action;
use App\Entity\Complexity;
use App\Entity\Country;
use App\Entity\Organization;
use App\Entity\Priority;
use App\Entity\Relation;
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
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api')]
class ActionController extends AbstractController

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

    #[Route('/actions/actions-current-organization', name: "actions_current_organization", methods: ["get"])]
    #[IsGranted('ROLE_ADMIN', message: "the authenticated user is not an admin")]
    public function actionsCurrentOrganization(#[CurrentUser()] ?User $user): Response
    {
        $actions = $this->entityManager->getRepository(User::class)->find($user->getId())
            ->getOrganization()
            ->getActions();

        $normalized = array();

        foreach ($actions as $action) {
            $normalized[] = [
                "id" => $action->getId(),
                "title" => $action->getTitle(),
            ];
        }

        return $this->json($normalized);
    }

    #[Route('/actions', name: "actions.store", methods: ["post"])]
    #[IsGranted('ROLE_ADMIN', message: "the authenticated user is not an admin")]
    public function store(Request $request, #[CurrentUser()] ?User $currentUser)
    {
        $decoded = json_decode($request->getContent());
        $storeAction = function (object $user) use ($decoded, $currentUser) {
            $action = new Action();
            $action->setOrganization($currentUser->getOrganization());
            $action->setTitle($decoded->title);
            $action->setComplexity($this->entityManager->getRepository(Complexity::class)->find($decoded->complexity));
            $action->setPriority($this->entityManager->getRepository(Priority::class)->find($decoded->priority));
            $action->setDescription($decoded->description);
            $action->setStartAt(Carbon::parse($decoded->startAt)->toImmutable());
            $action->setDueAt(Carbon::parse($decoded->dueAt)->toImmutable());
            $action->setUser($user);
            return $action;
        };
        $getUsersByRole = function ($users, $role) {
            $usersWithRole = array();
            foreach ($users as $user) {
                if (in_array($role, $user->getRoles())) {
                    if (in_array($role, $user->getRoles())) {
                        $usersWithRole[] = $user;
                    }
                }
            }
            return $usersWithRole;
        };

        $assignUsers = array();
        if ($decoded->assign->user) {
            $assignUsers[] = $this->entityManager->getRepository(User::class)->find($decoded->assign->user);
            // return $this->json($assignUsers[0]->getEmail());
        } else if ($decoded->assign->role) {
            $assignRole = $decoded->assign->role;
            if ($decoded->assign->organization) {
                // assign the action to the users who belongs to this organization and have this role 
                $users = $this->entityManager->getRepository(User::class)->findByOrganization($this->entityManager->getRepository(Organization::class)->find($decoded->assign->organization));
                $assignUsers = $getUsersByRole($users, $assignRole);
            } else {
                $users = $this->entityManager->getRepository(User::class)->findAll();
                $assignUsers = $getUsersByRole($users, $assignRole);
            }
        } else {
            $assignUsers = $this->entityManager->getRepository(User::class)->findByOrganization($this->entityManager->getRepository(Organization::class)->find($decoded->assign->organization));
            // return $this->json(["message" => "ya hala"]);
        }

        if (count($assignUsers) > 0) {
            $errors = $this->validator->validate($storeAction($assignUsers[0]));

            if (count($errors) > 0) {
                return $this->json($errors);
            }
            $this->entityManager->beginTransaction();
            try {
                // Persist the entity
                foreach ($assignUsers as $assignUser) {
                    $this->entityManager->persist($storeAction($assignUser));
                    $this->entityManager->flush();
                }
                // Commit the transaction
                $this->entityManager->commit();
                return $this->json(['message' => 'action has been created successfully'], Response::HTTP_CREATED);
            } catch (\Exception $e) {
                // Rollback the transaction on error
                $this->entityManager->rollback();

                return $this->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            return $this->json(["message" => "You need to assign the action to an entity"]);
        }
    }

    #[IsGranted('ROLE_ADMIN', message: "the authenticated user is not an admin")]
    #[Route('/organizations/{id}', methods: ["DELETE"])]
    function deleteOrganization($id, #[CurrentUser()] ?User $user)
    {
        $organization = $this->entityManager->getRepository(Organization::class)->find($id);
        $name = $organization->getName();
        $myOrganizations = $user->getOrganization()->getOrganizations();
        if ($myOrganizations->contains($organization)) {
            $this->entityManager->remove($organization);
            $this->entityManager->flush();
            return $this->json(["message" => "the user with the name " . $name . " has been deleted"]);
        } else {
            return $this->json(["message" => "authorized to delete only your organization"], status: 401);
        }
    }
}
