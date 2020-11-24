<?php

namespace App\Api;

use App\Repository\InvestmentRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * @Route("/users", name="users_")
 */
class UserController
{
    /**
     * @Route("/", name="show")
     */
    public function show(SerializerInterface $serializer, InvestmentRepository $investmentRepository): JsonResponse
    {
        return new JsonResponse(
            $serializer->serialize($investmentRepository->findAll(), 'json', ['groups' => 'show']),
            200,
            [],
            true
        );
    }
}
