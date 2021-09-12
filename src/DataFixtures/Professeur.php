<?php

namespace App\DataFixtures;

use App\Entity\Groupe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class Professeur extends Fixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        // initialisation de l'objet Faker
        $faker = Faker\Factory::create('fr_FR');
        // create 5 Job! Bam!
        //dd($this);
        for ($i = 0; $i < 50; $i++) {
            $prof = new \App\Entity\Professeur();
            $prof->setLastName($faker->lastName);
            $prof->setFirstName($faker->firstName);
            $prof->setBirthDay(date_modify(new \DateTime(), '-'.random_int(24, 65).' year'));
            $manager->persist($prof);
            $this->addReference('ref-professeur'.$i, $prof);
        }
        $manager->flush();
    }

     public function getDependencies()
    {
        return array(
            Professeur::class,
        );
    }

    public static function getGroups(): array
    {
        return ['group2'];
    }

    public function getOrder()
    {
        return 4; // the order in which fixtures will be loaded
    }
}
