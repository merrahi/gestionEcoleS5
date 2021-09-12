<?php

namespace App\DataFixtures;

use App\Entity\Groupe;
use App\Entity\Professeur;
use App\Service\RandomFloat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Exam extends Fixture implements OrderedFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        // initialisation de l'objet Faker
        $faker = Faker\Factory::create('fr_FR');
        $rondom=new RandomFloat();
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
        /* Entre 18 et 20 : Félicitations !
     Entre 16 et 18 : Très bien !
     Entre 14 et 16 : Bien ! ou Bon travail !
     Entre 12 et 14 : Assez bien ou Assez bon travail
 Entre 10 et 12 : Passable ou Correct ou Travail correct
 Entre 08 et 10 : Des difficultés (malgré XXX s'il y avait des points positifs)
 Entre 06 et 08 : Insuffisant ou Travail insuffisant
 Entre 01 et 06 : Très insuffisant*/
        $appreciation=['Félicitations !','Très bien !','mensuel','Bien !','Assez bien ','Passable','Des difficultés','Insuffisant','Très insuffisant'];
        // create 5 Job! Bam!
        //dd($this);
        $type=['EFM','Controle'];
        for ($i = 0; $i < 6; $i++) {
            $groupe=$this->getReference( "ref-".$names[$i]);
            $exam = new \App\Entity\Exam();
            $exam->setGroupe($groupe);
            $exam->setNameE($faker->lastName);
            $exam->setTypeE($type[random_int(0,1)]);
            $exam->setFaitLe(date_modify(new \DateTime('Europe/Paris'), '+'.random_int(1, 6).' days'));
            $exam->setSalle($this->getReference( "ref-salle".random_int(0, 9)));
            $exam->setModule($this->getReference( "ref-module".random_int(0, 19)));
            $this->addReference('ref-exam'.$i, $exam);
            $manager->persist($exam);
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
            \App\Entity\Etudiant::class,
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
