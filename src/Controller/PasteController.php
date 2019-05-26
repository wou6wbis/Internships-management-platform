<?php

namespace App\Controller;

use App\Entity\Paste;
use App\Form\PasteType;
use App\Repository\PasteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paste")
 */
class PasteController extends Controller
{
    /**
     * @Route("/", name="paste_index", methods="GET")
     */
    public function index(PasteRepository $pasteRepository): Response
    {
        return $this->render('paste/index.html.twig', ['pastes' => $pasteRepository->findAll()]);
    }

    /**
     * @Route("/new", name="paste_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $paste = new Paste();
        $form = $this->createForm(PasteType::class, $paste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($paste);
            $em->flush();
            
            // Make sure message will be displayed after redirect
            $this->get('session')->getFlashBag()->add('message', 'paste bien ajouté');
            
            return $this->redirectToRoute('paste_index');
        }

        return $this->render('paste/new.html.twig', [
            'paste' => $paste,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="paste_show", methods="GET")
     */
    public function show(Paste $paste): Response
    {
        return $this->render('paste/show.html.twig', ['paste' => $paste]);
    }

    /**
     * @Route("/{id}/edit", name="paste_edit", methods="GET|POST")
     */
    public function edit(Request $request, Paste $paste): Response
    {
        $form = $this->createForm(PasteType::class, $paste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            // Make sure message will be displayed after redirect
            $this->get('session')->getFlashBag()->add('message', 'paste bien modifié');
            
            return $this->redirectToRoute('paste_edit', ['id' => $paste->getId()]);
        }

        return $this->render('paste/edit.html.twig', [
            'paste' => $paste,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="paste_delete", methods="DELETE")
     */
    public function delete(Request $request, Paste $paste): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paste->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($paste);
            $em->flush();
            
            // Make sure message will be displayed after redirect
            $this->get('session')->getFlashBag()->add('message', 'paste supprimé');
            
        }

        return $this->redirectToRoute('paste_index');
    }
}
