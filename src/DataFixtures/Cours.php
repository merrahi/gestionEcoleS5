<?php

namespace App\DataFixtures;

use App\Entity\Groupe;
use App\Entity\Professeur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class Cours extends Fixture implements OrderedFixtureInterface
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
        $periodic=['une_fois','hebdomadaire','mensuel'];
        // create 5 Job! Bam!
        //dd($this);
        for ($i = 0; $i < 40; $i++) {
            $cours = new \App\Entity\Cours();
            $cours->setIntro($faker->lastName);
            $cours->setPeriodic($periodic[random_int(0, 2)]);
            //$date = new \DateTime('2017-10-17', new \DateTimeZone('Europe/Paris'));
            $cours->setFaitLe(date_modify(new \DateTime('Europe/Paris'), '+'.random_int(0, 30).' days'));
            $cours->setStartAt(\DateTime::createFromFormat('H\h i\m s\s','8h 00m 03s'));
            $cours->setEndAt(date_modify($cours->getStartAt(), '-'.random_int(1, 5).' hour'));
            // duree
            $interval = $cours->getEndAt()->diff($cours->getStartAt())->format("%h");
            $cours->setGroupe($this->getReference( "ref-".$names[random_int(0, 5)]));
            $cours->setProfesseur($this->getReference( "ref-professeur".random_int(0, 49)));
            $cours->setModule($this->getReference( "ref-module".random_int(0, 19)));
            $cours->setSalle($this->getReference( "ref-salle".random_int(0, 9)));
            //dd(etu);
            //etu->getCategory()->setName("Informatique");
            $manager->persist($cours);
        }
        $manager->flush();
    }

     public function getDependencies()
    {
        return array(
            Groupe::class,
            Professeur::class,
            \App\Entity\Salle::class,
            \App\Entity\Module::class,
        );
    }

    public static function getGroups(): array
    {
        return ['group2'];
    }

    public function getOrder()
    {
        return 6; // the order in which fixtures will be loaded
    }
}
