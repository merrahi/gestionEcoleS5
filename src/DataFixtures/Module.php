<?php

namespace App\DataFixtures;

/*use App\Entity\Module;*/
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class Module extends Fixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $level=[ '2ime Année','1iere Année'];
        $names =
            [
                ['libelle' => 'TDM201','level' => '2ime Année','filiere' => 'Multimedia'],
                ['libelle' => 'TDM101','level' => '1iere Année','filiere' => 'Multimedia'],
                ['libelle' => 'TRI201','level' => '2ime Année','filiere' => 'Réseaux Informatique'],
                ['libelle' => 'TRI101','level' => '1iere Année','filiere' => 'Réseaux Informatique'],
                ['libelle' => 'TDI201','level' => '2ime Année','filiere' => 'Développement Informatique'],
                ['libelle' => 'TDI101','level' => '1iere Année','filiere' => 'Développement Informatique'],
            ];
        $filieres = [
            ['libelle' => 'Développement Informatique','secteur' => 'NTIC'],
            ['libelle' => 'Réseaux Informatique','secteur' => 'NTIC'],
            ['libelle' => 'Multimedia','secteur' => 'Ntic'],
            ['libelle' => 'Gestion des Entreprises','secteur' => 'AGC']
        ];
        for ($i = 0; $i < 20; $i++) {
            $module = new \App\Entity\Module();
            $module->setCode("Module ".$i);
            $module->setLevel($level[random_int(0,1)]);
            $module->setLibelle($faker->lastName);
            $module->setMasseHoraires(random_int(15,180));
            $module->setFiliere($this->getReference( "ref-".$filieres[random_int(0,3)]['libelle']));
            $module->addGroupe($this->getReference( "ref-".$names[random_int(0,5)]['libelle']));// "ref-".$name['filiere']));
            /*$module->setBirthDay(date_modify(new \DateTime(), '-'.random_int(24, 65).' year'));*/
            $manager->persist($module);
            $this->addReference('ref-module'.$i, $module);
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
        return 5; // the order in which fixtures will be loaded
    }
}
