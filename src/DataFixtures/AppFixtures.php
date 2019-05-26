<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use App\Entity\Todo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadTodos($manager);
    }
    
    private function loadTodos(ObjectManager $manager)
    {
        foreach ($this->getTodosData() as [$title, $completed]) {
            $todo = new Todo();
            $todo->setTitle($title);
            $todo->setCompleted($completed);
            $manager->persist($todo);
        }
        $manager->flush();
    }
    
    private function getTodosData()
    {
        // todo = [title, completed];
        yield ['apprendre les bases de PHP', true];
        yield ['devenir un pro du Web', false];
        yield ['monter une startup',  false];
        yield ['devenir maître du monde', false];
        
    }
    
    
}