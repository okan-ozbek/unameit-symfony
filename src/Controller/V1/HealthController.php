<?php

namespace App\Controller\V1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HealthController extends AbstractController
{
    #[Route('/v1/health', name: 'v1_health', methods: ['GET'])]
    public function index(): Response
    {
        return $this->json(['message' => 'API is running.'], Response::HTTP_OK);
    }
}
