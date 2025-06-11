<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class ProdutosController extends AbstractController
{
    #[Route('/produtos', methods:['POST'], name: 'produtos_create')]
    public function create(
        #[MapRequestPayload(acceptFormat: 'json')]
        Produto $produto,

        EntityManagerInterface $entityManager
    ): JsonResponse {
        $entityManager->persist($produto);
        $entityManager->flush();

        return $this->json($produto);
    }
}
