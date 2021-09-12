<?php

namespace App\DataFixtures;


use App\Entity\Etudiant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class Filiere extends Fixture implements FixtureGroupInterface
{
    //  const CATEGORY_REFERENCE='categories';
    public $groupes;
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        // Liste des noms de catégorie à ajouter
        $filieres = [
            ['libelle' => 'Développement Informatique','secteur' => 'NTIC'],
            ['libelle' => 'Réseaux Informatique','secteur' => 'NTIC'],
            ['libelle' => 'Multimedia','secteur' => 'Ntic'],
            ['libelle' => 'Gestion des Entreprises','secteur' => 'AGC']
            ];

        foreach ($filieres as $filiere) {
            // On crée la catégorie
            $fil= new \App\Entity\Filiere();
            $fil->setLibelle($filiere['libelle']);
            $fil->setSecteur($filiere['secteur']);
            // On la persiste
            $manager->persist($fil);
            $manager->flush();
            $this->addReference('ref-'.$filiere['libelle'], $fil);
        }
    }

    public static function getGroups(): array
    {
        return ['group1'];
    }

    public function getDependencies()
    {
        return array(
            Etudiant::class,
        );
    }

    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}