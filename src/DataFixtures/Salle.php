<?php

namespace App\DataFixtures;


/*use App\Entity\Salle;*/
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class Salle extends Fixture implements FixtureGroupInterface
{

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        // Liste des noms de catégorie à ajouter
        $cats= array(
            'Salle Spécialisé',
            'Salle de cours',
            'Salle de TPs',
            'Amphi'
        );
            // On crée la catégorie
         for ($i = 0; $i < 10; $i++) {
                $sal = new \App\Entity\Salle();
                $sal->setNumero($i);
                $sal->setLibelle('salle-'.$i);
                $sal->setCategorie($cats[random_int(0, 3)]);
                $manager->persist($sal);
                $this->addReference('ref-salle'.$i, $sal);
            }
            $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group1'];
    }

    public function getDependencies()
    {
        return array(
            Salle::class,
        );
    }

    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}