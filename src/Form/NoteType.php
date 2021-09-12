<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\Exam;
use App\Entity\Module;
use App\Entity\Note;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('moyenne',NumberType::class,[
                'attr'  => [
                    'class' => 'form-group form-control form-control-lg'
                ],
            ])
            ->add('appreciation', ChoiceType::class, [
                'choices' => [
                        'Félicitations !'  => 'Félicitations !',
                        'Très bien !' => 'Très bien !' ,
                        'Bien !' => 'Bien !',
                        'Assez bien' => 'Assez bien',
                        'Passable' => 'Passable',
                        'Des difficultés' => 'Passable',
                        'Insuffisant' => 'Insuffisant',
                        'Très insuffisant' => 'Très insuffisant',
                ],
                'choice_attr' => function($choice, $key, $value) {
                    // adds a class like attending_yes, attending_no, etc
                    return ['class' => 'periodic_'.strtolower($key)];
                },
                'attr'  => [
                    'class' => 'form-group form-control form-control-lg'
                ],
            ])
            ->add('bareme',NumberType::class,[
                'attr'  => [
                    'class' => 'form-group form-control form-control-lg'
                ],
            ])
            ->add('etudiant', EntityType::class, [
                'class' => Etudiant::class,
                'choice_label' => function ($etudiant) {
                    return $etudiant->getFullName();
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
            ->add('exam', EntityType::class, [
                'class' => Exam::class,
                'choice_label' => 'name_e',
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
            'data_class' => Note::class,
        ]);
    }
}
