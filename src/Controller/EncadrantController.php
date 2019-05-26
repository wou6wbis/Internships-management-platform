<?php

namespace App\Controller;

use App\Entity\Encadrant;
use App\Form\EncadrantType;
use App\Repository\EncadrantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/encadrant")
 */
class EncadrantController extends AbstractController
{
    /**
     * @Route("/", name="encadrant_index", methods="GET")
     */
    public function index(EncadrantRepository $encadrantRepository): Response
    {
        return $this->render('encadrant/index.html.twig', ['encadrants' => $encadrantRepository->findAll()]);
    }

    /**
     * @Route("/new", name="encadrant_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $encadrant = new Encadrant();
        $form = $this->createForm(EncadrantType::class, $encadrant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($encadrant);
            $em->flush();

            return $this->redirectToRoute('encadrant_index');
        }

        return $this->render('encadrant/new.html.twig', [
            'encadrant' => $encadrant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="encadrant_show", methods="GET")
     */
    public function show(Encadrant $encadrant): Response
    {
        return $this->render('encadrant/show.html.twig', ['encadrant' => $encadrant]);
    }

    /**
     * @Route("/{id}/edit", name="encadrant_edit", methods="GET|POST")
     */
    public function edit(Request $request, Encadrant $encadrant): Response
    {
        $form = $this->createForm(EncadrantType::class, $encadrant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('encadrant_index', ['id' => $encadrant->getId()]);
        }

        return $this->render('encadrant/edit.html.twig', [
            'encadrant' => $encadrant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="encadrant_delete", methods="DELETE")
     */
    public function delete(Request $request, Encadrant $encadrant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$encadrant->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($encadrant);
            $em->flush();
        }

        return $this->redirectToRoute('encadrant_index');
    }
}
