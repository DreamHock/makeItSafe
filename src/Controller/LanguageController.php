<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class LanguageController extends AbstractController
{
    private $entityManager;
    function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/languages', name: 'app_languages', methods: ["get"])]
    public function index(): JsonResponse
    {
        $conn = $this->entityManager->getConnection();
        return $this->json($conn->executeQuery('SELECT * from language')->fetchAllAssociative());
    }
}
