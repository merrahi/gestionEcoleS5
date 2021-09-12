<?php

namespace App\Form;

use App\Entity\Exam;
use App\Entity\Module;
use App\Entity\Professeur;
use App\Entity\Salle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ExamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name_e',TextType::class,[
                // adds a class that can be selected in JavaScript
                'attr'  => [
                    'class' => 'form-group form-control form-control-lg'
                ]
            ])
            ->add('type_e',ChoiceType::class,[
                // adds a class that can be selected in JavaScript
                'choices'  => array(
                    'Examen De Fin de Module' => 'EFM',
                    'Contrôle' => 'controle',
                    'Autres' => 'autres'
                ),
                'attr'  => [
                    'class' => 'form-group form-control form-control-lg'
                ]
            ])

            ->add('state',ChoiceType::class,[
                // adds a class that can be selected in JavaScript
                'choices'  => array(
                    'Programmé' => 'programme',
                    'Fait' => 'fait',
                    'reporté' => 'reporte',
                    'annulé' => 'annule',
                ),
                'attr'  => [
                    'class' => 'form-group form-control form-control-lg'
                ]
            ])
            ->add('fait_le', DateTimeType::class,[
                //'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'dd-MM-YYYY HH:mm',
                'data' => new \DateTime(),
                'view_timezone' =>  $options['app.time_zone'],

                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,

                // adds a class that can be selected in JavaScript
                'attr'  => [
                    'class' => 'form-group form-control-lg'
                ]
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
            ->add('surveillants', EntityType::class, [
                'class' => Professeur::class,
                'choice_label' => 'last_name',
                'multiple'=>true,

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
            'data_class' => Exam::class,
            'app.time_zone' =>null
        ]);
    }
}
