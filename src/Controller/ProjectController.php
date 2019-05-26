<?php

namespace App\Controller;
use App\Entity\Todo;
use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/project")
 */
class ProjectController extends Controller
{
    /**
     * @Route("/", name="project_index", methods="GET")
     */
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('project/index.html.twig', ['projects' => $projectRepository->findAll()]);
    }

    /**
     * @Route("/new", name="project_new", methods="GET|POST")
     */
    
    /**
     * @Route("/new", name="project_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        // 1) création d'un projet en mémoire
        $project = new Project();
        $em = $this->getDoctrine()->getManager();
        $todo = new Todo();
       
        // 3) création d'un formulaire d'affichage du projet
        //    et de ses sous-tâches
        $form = $this->createForm(ProjectType::class, $project);
        
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            // Make sure message will be displayed after redirect
            $this->get('session')->getFlashBag()->add('message', 'projet bien modifié');
            
        }
        return $this->render('project/new.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="project_show", methods="GET")
     */
    public function show(Project $project): Response
    {
        return $this->render('project/show.html.twig', ['project' => $project]);
    }

    /**
     * @Route("/{id}/edit", name="project_edit", methods="GET|POST")
     */
    public function edit(Request $request, Project $project): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('project_edit', ['id' => $project->getId()]);
        }

        return $this->render('project/edit.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="project_delete", methods="DELETE")
     */
    public function delete(Request $request, Project $project): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($project);
            $em->flush();
        }

        return $this->redirectToRoute('project_index');
    }
}
