<?php

namespace App\Controller;

use App\Entity\Investment;
use App\Form\InvestmentType;
use App\Repository\InvestmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/investment")
 */
class InvestmentController extends AbstractController
{
    /**
     * @Route("/", name="investment_index", methods={"GET"})
     */
    public function index(InvestmentRepository $investmentRepository): Response
    {
        return $this->render('investment/index.html.twig', [
            'investments' => $investmentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="investment_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $investment = new Investment();
        $form = $this->createForm(InvestmentType::class, $investment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $investment->setCreatedAt(new \DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($investment);
            $entityManager->flush();

            return $this->redirectToRoute('investment_index');
        }

        return $this->render('investment/new.html.twig', [
            'investment' => $investment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="investment_show", methods={"GET"})
     */
    public function show(Investment $investment): Response
    {
        return $this->render('investment/show.html.twig', [
            'investment' => $investment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="investment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Investment $investment): Response
    {
        $form = $this->createForm(InvestmentType::class, $investment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('investment_index');
        }

        return $this->render('investment/edit.html.twig', [
            'investment' => $investment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="investment_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Investment $investment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$investment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($investment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('investment_index');
    }
}
