<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api')]
class RoleController extends AbstractController
{
    public $entityManager;
    // public $normalizer;
    // public $validator;
    public function __construct(
        EntityManagerInterface $entityManager
        // , NormalizerInterface $normalizer, ValidatorInterface $validator
    ) {
        $this->entityManager = $entityManager;
        // $this->normalizer = $normalizer;
        // $this->validator = $validator;
    }
    #[IsGranted('ROLE_ADMIN', message: "the authenticated user is not an admin")]
    #[Route('/roles/organization={organizationId}', methods: ["GET"])]
    function findRolesByOrganization($organizationId)
    {
        $rolesByOrganization = $this->entityManager->createQuery(
            'SELECT distinct r.id, r.name from App\Entity\User u join u.role r join u.organization o where o.id = :organizationId '
        )
            ->setParameter('organizationId', $organizationId)
            ->getResult();

        return $this->json($rolesByOrganization);
    }
}
