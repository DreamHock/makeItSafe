<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\Organization;
use App\Entity\Relation;
use App\Entity\User;
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
class OrganizationController extends AbstractController

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

    #[Route('/organizations/organizations-current-organization', name: "organizations_current_organization", methods: ["get"])]
    #[IsGranted('ROLE_ADMIN', message: "the authenticated user is not an admin")]
    public function organizationsCurrentOrganization(#[CurrentUser()] ?User $user): Response
    {
        $organizations = $this->entityManager->getRepository(User::class)->find($user->getId())
            ->getOrganization()
            ->getOrganizations();

        $normalized = array();
        foreach ($organizations as $organization) {
            $normalized[] = [
                "id" => $organization->getId(),
                "name" => $organization->getName(),
            ];
        }

        return $this->json($normalized);
    }

    #[Route('/organizations', name: "organizations.store", methods: ["post"])]
    #[IsGranted('ROLE_ADMIN', message: "the authenticated user is not an admin")]
    public function store(Request $request, #[CurrentUser()] ?User $currentUser)
    {
        $decoded = json_decode($request->getContent());
        $organization = new Organization();
        $organization->setName($decoded->name);
        $organization->setParent($currentUser->getOrganization());
        $organization->setRelation($this->entityManager->getRepository(Relation::class)->find($decoded->relation));
        $organization->setPostalAddress($decoded->postalAddress);
        $organization->setPostalCode($decoded->postalCode);
        $organization->setCity($decoded->city);
        $organization->setCountry($this->entityManager->getRepository(Country::class)->find($decoded->country));
        $organization->setWebsite($decoded->website);
        $organization->setSIRET((int)$decoded->siret);
        $organization->setActivityArea($decoded->activityArea);

        $errors = $this->validator->validate($organization);

        if (count($errors) > 0) {
            return $this->json($errors);
        }
        $this->entityManager->beginTransaction();
        try {
            // Persist the entity
            $this->entityManager->persist($organization);
            $this->entityManager->flush();
            // Commit the transaction
            $this->entityManager->commit();
            return $this->json(['message' => 'Organization created successfully'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            // Rollback the transaction on error
            $this->entityManager->rollback();

            return $this->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[IsGranted('ROLE_ADMIN', message: "the authenticated user is not an admin")]
    #[Route('/organizations/{id}', methods: ["DELETE"])]
    function delete($id, #[CurrentUser()] ?User $user)
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
