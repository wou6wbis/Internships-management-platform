<?php
/**
 * Gestion de la commande de liste des tâches actives en ligne de commande
 *
 * @copyright  2018 Telecom SudParis
 * @license    "MIT/X" License - cf. LICENSE file at project root
 */

namespace App\Command;

use App\Entity\Todo;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;


/**
 * Command ListactiveTodos
 *
 * cf. https://symfony.com/doc/current/console.html
 *
 */
class ListactiveTodosCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('app:list-active-todos')
        
        // the short description shown while running "php bin/console list"
        ->setDescription('List the active todos.')
        
        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp("This command allows you to list the todos which are active, i.e. not yet completed")
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $errOutput = $output instanceof ConsoleOutputInterface ? $output->getErrorOutput() : $output;
        
        // entityManager
        $em = $this->getContainer()->get('doctrine')->getManager(); 
        
        // récupère une liste toutes les instances de la classe Todo
        $todos = $em->getRepository(Todo::class)->findAll();
        
        // filtrer les tâches pas encore terminées
        $actives=array();
        foreach($todos as $todo) {
            if(! $todo->getCompleted()) {
                $actives[] = $todo;
            }
        }
        
        if(! empty($actives)) {
            $output->writeln('list of active todos:');
            foreach($actives as $todo) {
                //$output->writeln($todo->__toString());
                $output->writeln($todo);
            }
        } else {
            $errOutput->writeln('<error>no active todos found!</error>');
        }

// Alternative basée sur Doctrine
//         // récupère une liste toutes les instances de la classe Todo dont completed vaut false
//         $todos = $em->getRepository(Todo::class)->findByCompleted(false);
        
//         if(! empty($todos)) {
//             $output->writeln('list of active todos:');
//             foreach($todos as $todo) {
//                 //$output->writeln($todo->__toString());
//                 $output->writeln($todo);
//             }
//         } else {
//             $errOutput->writeln('<error>no active todos found!</error>');
//         }
    }
}
