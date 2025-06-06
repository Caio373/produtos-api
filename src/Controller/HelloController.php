<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class HelloController extends AbstractController
{
    #[Route('/hello', name: 'app_hello', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Hello world',
        ]);
    }

    #[Route('/hello', name: 'post_hello', methods: ['POST'])]
        public function postHello(Request $request): JsonResponse {
            $nome = $request->request->all()['nome'];
            return $this->json([
                'menssage' => "Hello $nome"
            ]);
    }
}
