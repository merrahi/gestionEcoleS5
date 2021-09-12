<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Professeur;
use App\Entity\Salle;
use App\Entity\Cours;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intro',TextType::class,[
                // adds a class that can be selected in JavaScript
                'attr'  => [
                    'class' => 'form-group form-control form-control-lg'
                ]
            ])
            ->add('fait_le', DateTimeType::class,[
                //'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'dd-MM-YYYY',
                'data' => new \DateTime(),
                'view_timezone' =>  $options['app.time_zone'],

                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,

                // adds a class that can be selected in JavaScript
                'attr'  => [
                    'class' => 'form-group form-control-lg'
                ]
            ])
            ->add('start_at', DateTimeType::class,[
                //'widget' => 'choice',
                // this is actually the default format for single_text
                'format' => 'HH:mm',
                'data' => new \DateTime(),
                'view_timezone' => $options['app.time_zone'],

                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,

                // adds a class that can be selected in JavaScript
                'attr'  => [
                    'class' => 'form-group form-control-lg'
                ],


            ])
            ->add('end_at', DateTimeType::class,[
                //'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'HH:mm',
                'data' => new \DateTime("+4 hours"),
                'view_timezone' =>  $options['app.time_zone'],

                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,

                // adds a class that can be selected in JavaScript
                'attr'  => [
                    'class' => 'form-group form-control-lg'
                ],


            ])
            ->add('periodic', ChoiceType::class, [
                'choices' => [
                    'Une Fois' => 'une_fois',
                    'Hebdomadaire' => 'hebdomadaire',
                    'Mensuel' => 'Mensuel',
                ],
                'choice_attr' => function($choice, $key, $value) {
                    // adds a class like attending_yes, attending_no, etc
                    return ['class' => 'periodic_'.strtolower($key)];
                },
                'attr'  => [
                    'class' => 'form-group form-control form-control-lg'
                ],
            ])
            ->add('salle', EntityType::class, [
                'class' => Salle::class,
                'choice_label' => 'libelle',
                'attr'  => [
                    'class' => 'form-group form-control form-control-lg'
                ],
                'constraints'=>[
                    new NotBlank(),
                ]
            ])
            ->add('professeur', EntityType::class, [
                'class' => Professeur::class,
                'choice_label' => function ($professeur) {
                            return $professeur->getFullName();
                },
                'attr'  => [
                    'class' => 'form-group form-control form-control-lg'
                ],
                'constraints'=>[
                    new NotBlank(),
                ]
            ])
            ->add('module', EntityType::class, [
                'class' => Module::class,
                'choice_label' => 'libelle',
                'attr'  => [
                    'class' => 'form-group form-control form-control-lg'
                ],
                'constraints'=>[
                    new NotBlank(),
                ]
            ])
            ->add('save', SubmitType::class,[
                'attr'  => [
                    'class' => 'btn btn-primary btn-user btn-block'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
            'app.time_zone' =>null
        ]);
    }
}
