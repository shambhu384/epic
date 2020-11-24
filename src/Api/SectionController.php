<?php

namespace App\Api;

use App\Repository\SectionRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * @Route("/sections", name="sections_")
 */
class SectionController
{
    /**
     * @Route("/", name="show")
     */
    public function show(SerializerInterface $serializer, SectionRepository $sectionRepository): JsonResponse
    {
        return new JsonResponse(
            $serializer->serialize($sectionRepository->findAll(), 'json', ['groups' => 'sections']),
            200,
            [],
            true
        );
    }
}
