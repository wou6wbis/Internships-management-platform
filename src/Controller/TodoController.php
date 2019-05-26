<?php
/**
 * Gestion de la page d'accueil de l'application
 *
 * @copyright  2017 Telecom SudParis
 * @license    "MIT/X" License - cf. LICENSE file at project root
 */

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Todo;
use App\Form\TodoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Controleur Todo
 * @Route("/todo")
 */
class TodoController extends Controller
{    
    /**
     * Lists all todo entities.
     * @Route("/", name = "todo_home", methods="GET")
     * @Route("/list", name = "todo_list", methods="GET")
     * @Route("/index", name="todo_index", methods="GET")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $todos = $em->getRepository(Todo::class)->findAll();
        
        //dump($todos);
        
        return $this->render('todo/index.html.twig', array(
            'todos' => $todos,
        ));
    }
    /**
     * Lists all active todo entities.
     *
     * The todo entities which aren't yet completed
     *
     * @Route("/list-active", name = "todo_active_list", methods="GET")
     */
    public function activelistAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        // $todos = $em->getRepository(Todo::class)->findByCompleted(false);
        $todos = $em->getRepository(Todo::class)->findAll(false);
        
        return $this->render('todo/active-index.html.twig', array(
            'todos' => $todos,
        ));
    }
    /**
     * Finds and displays a todo entity.
     *
     * @Route("/{id}", name="todo_show", requirements={ "id": "\d+"}, methods="GET")
     */
    public function showAction(Todo $todo): Response
    {
        return $this->render('todo/show.html.twig', array(
            'todo' => $todo,
        ));
    }
    
    /**
     * @Route("/new", name="todo_new", methods="GET|POST")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function new(Request $request): Response
    {
        $todo = new Todo();
        $form = $this->createForm(TodoType::class, $todo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $todo->setCreated(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($todo);
            $em->flush();
            
            // Make sure message will be displayed after redirect
            $this->get('session')->getFlashBag()->add('message', 'tâche bien ajoutée');
            
            return $this->redirectToRoute('todo_index');
        }
        
        return $this->render('todo/new.html.twig', [
            'todo' => $todo,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/project/{id}/addtodo", name="todo_add", methods="GET|POST")
     */
    public function add(Request $request, Project $project): Response
    {
        $todo = new Todo();
        $form = $this->createForm(TodoType::class, $todo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $todo->setCreated(new \DateTime());
            $project->addTodo($todo);
            $em = $this->getDoctrine()->getManager();
            $em->persist($todo);
            $em->flush();
            
            // Make sure message will be displayed after redirect
            $this->get('session')->getFlashBag()->add('message', 'tâche bien ajoutée au projet');
            
            return $this->redirectToRoute('project_show', array('id' => $project->getId() ));
        }
        
        return $this->render('todo/add.html.twig', [
            'project' => $project,
            'todo' => $todo,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/{id}/edit", name="todo_edit", methods="GET|POST")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function edit(Request $request, Todo $todo): Response
    {
        $form = $this->createForm(TodoType::class, $todo);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $todo->setUpdated(new \DateTime());
            
            $this->getDoctrine()->getManager()->flush();
            
            $this->get('session')->getFlashBag()->add('message', 'tâche mise à jour');
            
            return $this->redirectToRoute('todo_show', ['id' => $todo->getId()]);
        }
        
        return $this->render('todo/edit.html.twig', [
            'todo' => $todo,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/{id}", name="todo_delete", methods="DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function delete(Request $request, Todo $todo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$todo->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($todo);
            $em->flush();
            
            // Make sure message will be displayed after redirect
            $this->get('session')->getFlashBag()->add('message', 'tâche supprimée');
            
        }
        
        return $this->redirectToRoute('todo_index');
    }
    
}
