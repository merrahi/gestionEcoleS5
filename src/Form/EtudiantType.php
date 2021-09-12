<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\Groupe;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('last_name', TextType::class,[
                'attr'  => [
                    'class' => 'form-group form-control form-control-lg'
                ],
            ])
            ->add('first_name', TextType::class,[
                'attr'  => [
                    'class' => 'form-group form-control form-control-lg'
                ],
            ])
            ->add('birth_day', DateTimeType::class,[
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'dd-MM-YYYY',

                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,

                // adds a class that can be selected in JavaScript
                'attr'  => [
                    'class' => 'form-group form-control form-control-lg'
                ],


            ])
            ->add('groupe', EntityType::class, [
                'class' => Groupe::class,
                'choice_label' => 'libelle',
                'attr'  => [
                    'class' => 'form-group form-control form-control-lg'
                ],
                'constraints'=>[
                    new NotBlank(),
                ]
            ])
            //->add('groupe',DateType::class)
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
