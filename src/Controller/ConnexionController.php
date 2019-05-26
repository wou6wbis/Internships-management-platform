<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Connexion;
use App\Entity\Etudiant;
use App\Entity\Encadrant;
use App\Form\ConnexionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controleur de la page d'accueil
 */
class ConnexionController extends Controller
{
    /**
     * @Route("/connexion", name="connexion", methods="GET|POST")
     */
    public function connect(Request $request): Response
    {
        $connexion = new Connexion();
        $form = $this->createForm(ConnexionType::class, $connexion);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $etudiant = $em->getRepository(Etudiant::class)->findOneBy([
                'username' =>$connexion->getUsername(),
                'password' =>$connexion->getPassword(),
            ]);
           
            if($etudiant==null){
                $encadrant = $em->getRepository(Encadrant::class)->findOneBy([
                    'username' =>$connexion->getUsername(),
                    'password' =>$connexion->getPassword(),
                ]);
                
                if($encadrant==null)
                {
                    return $this->render('connexion.html.twig', [
                        'connexion' => $connexion,
                        'form' => $form->createView(),
                    ]);
                }
                else{
                    $_SESSION["username"]=$connexion->getUsername();
                    $_SESSION["role"]="encadrant";
                   
                    
                    return $this->redirectToRoute('stage_index_encadrant');                }
                
            }
            $_SESSION["username"]=$connexion->getUsername();
            $_SESSION["role"]="etudiant";
            
            
            
            return $this->redirectToRoute('stage_index_etudiant');
        }
        return $this->render('connexion.html.twig', [
            'connexion' => $connexion,
            'form' => $form->createView(),
        ]);
        
        
        
    }
    
    /**
     * @Route("/deconnexion", name="deconnexion", methods="GET")
     */
    public function disconnect(Request $request): Response
    {
       
            $_SESSION["username"]=null;
            $_SESSION["role"]=null;
            
            
            
            
            return $this->redirectToRoute('connexion');
        }
        
        
        
        
   
    
}