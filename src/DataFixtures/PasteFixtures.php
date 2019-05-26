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

use App\Entity\Paste;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PasteFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadPastes($manager);
    }
    
    private function loadPastes(ObjectManager $manager)
    {
        foreach ($this->getPastesData() as [$title]) {
            $paste = new Paste();
            $paste->setContent($title);
            $paste->setContentType("text");
            $paste->setCreated(new \DateTime());
            $manager->persist($paste);
        }
        $manager->flush();
    }
    
    private function getPastesData()
    {
        yield ['composer require '];
        yield ['bin/console debug:router'];
        yield ['bin/console '];
        yield ['bin/phpunit'];
        
    }
    
    
}