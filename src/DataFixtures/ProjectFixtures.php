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

use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProjectFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadProjects($manager);
    }
    
    private function loadProjects(ObjectManager $manager)
    {
        foreach ($this->getProjectsData() as [$title, $description]) {
            $project = new Project();
            $project->setTitle($title);
            $project->setDescription($description);
            $manager->persist($project);
        }
        $manager->flush();
    }
    
    private function getProjectsData()
    {
        // project = [title, description];
        yield ['CSC4101', "Architectures et applications Web"];
        yield ['CSC4102', "Introduction au Génie Logiciel Orienté Objet"];
    }
    
    
}