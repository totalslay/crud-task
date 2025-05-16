<?php
namespace App\DataFixtures;

use App\Entity\Department;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager):void
    {
        $developmentDepartment = new Department();
        $developmentDepartment->setName('Разработка');
        $manager->persist($developmentDepartment);

        $marketingDepartment = new Department();
        $marketingDepartment->setName('Маркетинг');
        $manager->persist($marketingDepartment);

        $bark_bark = new User();
        $bark_bark->setFirstName('Иван');
        $bark_bark->setLastName('Иванов');
        $bark_bark->setAge('25');
        $bark_bark->setAddress('Street 34');
        $bark_bark->setStatus('Что то делает??');
        $bark_bark->setTelegram('@awooga');
        $bark_bark->setEmail('ivan@something.com');
        $bark_bark->setDepartment($developmentDepartment); 
        $manager->persist($bark_bark);

        $meow_meow = new User();
        $meow_meow->setFirstName('Fluttershy');
        $meow_meow->setLastName('DA PONY');
        $meow_meow->setAge('20');
        $meow_meow->setAddress('Another street 75');
        $meow_meow->setStatus('Что то делает??');
        $meow_meow->setTelegram('@destroy_em_all');
        $meow_meow->setEmail('transitiongoals@something.com');
        $meow_meow->setDepartment($developmentDepartment); 
        $manager->persist($meow_meow);


        

        $manager->flush();
    }
}
