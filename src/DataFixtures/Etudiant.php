<?php

namespace App\DataFixtures;

use App\Entity\Groupe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class Etudiant extends Fixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        // initialisation de l'objet Faker
        $faker = Faker\Factory::create('fr_FR');
        $names = array(
            'TDM201',
            'TDM101',
            'TRI101',
            'TRI201',
            'TDI101',
            'TDI201'
        );
        $city=['Evry','Paris','Lyon','Marseille','Nantes'];
        // create 5 Job! Bam!
        //dd($this);
        for ($i = 0; $i < 100; $i++) {
            $etu = new \App\Entity\Etudiant();
            $etu->setLastName($faker->lastName);
            $etu->setFirstName($faker->firstName);
            $etu->setBirthDay(date_modify(new \DateTime(), '-'.random_int(18, 30).' year'));
            //dd($this->getReference( "ref-".$names[random_int(0, 5)]));
            $etu->setGroupe($this->getReference( "ref-".$names[random_int(0, 5)]));
            //dd(etu);
            //etu->getCategory()->setName("Informatique");
            $manager->persist($etu);
        }
        $manager->flush();
    }

     public function getDependencies()
    {
        return array(
            Groupe::class,
        );
    }

    public static function getGroups(): array
    {
        return ['group2'];
    }

    public function getOrder()
    {
        return 7; // the order in which fixtures will be loaded
    }
}
