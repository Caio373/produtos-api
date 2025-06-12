<?php

namespace App\Controller;

use App\Entity\Produto;
use App\Repository\ProdutoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class ProdutosController extends AbstractController
{
    #[Route('/produtos', methods: ['POST'], name: 'produtos_create')]
    public function create(
        #[MapRequestPayload(acceptFormat: 'json')]
        Produto $produto,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $entityManager->persist($produto);
        $entityManager->flush();

        return $this->json($produto);
    }

    #[Route('/produtos', methods: ['GET'], name: 'produtos_list')]
    public function list(ProdutoRepository $produtoRepository): JsonResponse
    {
        return $this->json($produtoRepository->findAll());
    }

    #[Route('/produtos/{id}', methods: ['GET'], name: 'produtos_by_id')]
    public function getById(
        int $id,
        ProdutoRepository $produtoRepository
    ): JsonResponse {
        $produto = $produtoRepository->find($id);

        if (!$produto) {
            throw $this->createNotFoundException(
                'Produto de ID ' . $id . ' não encontrado!'
            );
        }

        return $this->json($produto);
    }

    #[Route('/produtos/{id}', methods: ['PUT'], name: 'produtos_update')]
    public function update(
        int $id,
        #[MapRequestPayload(acceptFormat: 'json')]
        Produto $produto,
        ProdutoRepository $produtoRepository,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $produtoSalvo = $produtoRepository->find($id);

        if (!$produtoSalvo) {
            throw $this->createNotFoundException(
                'Produto de ID ' . $id . ' não encontrado!'
            );
        }

        $produtoSalvo->setNome($produto->getNome());
        $produtoSalvo->setDescricao($produto->getDescricao());
        $produtoSalvo->setPreco($produto->getPreco());

        $entityManager->persist($produtoSalvo);
        $entityManager->flush();

        return $this->json($produtoSalvo);
    }
}
