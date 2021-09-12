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

class Note extends Fixture implements OrderedFixtureInterface
{
    private $randomFloat;

    public function __construct(RandomFloat $randomFloat)
    {
        $this->randomFloat = $randomFloat;
    }

    public function load(ObjectManager $manager)
    {
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
        /*
        Entre 18 et 20 : Félicitations !
        Entre 16 et 18 : Très bien !
        Entre 14 et 16 : Bien ! ou Bon travail !
        Entre 12 et 14 : Assez bien ou Assez bon travail
        Entre 10 et 12 : Passable ou Correct ou Travail correct
        Entre 08 et 10 : Des difficultés (malgré XXX s'il y avait des points positifs)
        Entre 06 et 08 : Insuffisant ou Travail insuffisant
        Entre 01 et 06 : Très insuffisant
        */
        $appreciation=['Félicitations !','Très bien !','mensuel','Bien !','Assez bien ','Passable','Des difficultés','Insuffisant','Très insuffisant'];
        for ($i = 0; $i < 6; $i++) {
            $exam=$this->getReference( "ref-exam".$i);
            $groupe=$exam->getGroupe();
            $module=$exam->getModule();
           /* $groupes = $this->getDoctrine()->getRepository(Groupe::class)->findAll();
            $product = $entityManager->getRepository(Product::class)->find($groupe);*/
            $etudiants=$groupe->getEtudiants();
            //$note = new \App\Entity\Note();
            foreach ($etudiants as $etudiant){
                $note = new \App\Entity\Note();
                $note->setBareme(20);
                $note->setMoyenne( round($this->randomFloat ->randomFloat(0,20), 2));
                $note->setAppreciation($appreciation[random_int(0, 6)]);
                $note->setEtudiant($etudiant);
                $note->setModule($module);
                $note->setExam($exam);
                $manager->persist($note);
            }

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
        return 8; // the order in which fixtures will be loaded
    }
}
