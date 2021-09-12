<?php

namespace App\DataFixtures;


use App\Entity\Etudiant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class Groupe extends Fixture implements FixtureGroupInterface
{
    //  const CATEGORY_REFERENCE='categories';
    public $groupes;
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        // Liste des noms de catégorie à ajouter
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

        foreach ($names as $name) {
            // On crée la catégorie
            $gr = new \App\Entity\Groupe();
            $gr->setLibelle($name["libelle"]);
            $gr->setLevel($name["level"]);
            $gr->setAnneeDebut(2020);
            $gr->setAnneeFin(2021);
            $gr->setFiliere($this->getReference( "ref-".$name['filiere']));
            //$gr->addModule($this->getReference( "ref-module".random_int(0, 19)));
            // On la persiste
            $manager->persist($gr);
            $manager->flush();
            //$this->getReferenceRepository();
           // $this->setReferenceRepository('ref-'.$name, $gr);
            $this->addReference('ref-'.$name['libelle'], $gr);

            //$this->setReference("tdm", $gr);
        }
       // dd($this);
    }

    public static function getGroups(): array
    {
        return ['group2'];
    }

    public function getDependencies()
    {
        return array(
            Module::class,
        );
    }

    public function getOrder()
    {
        return 8; // the order in which fixtures will be loaded
    }
}