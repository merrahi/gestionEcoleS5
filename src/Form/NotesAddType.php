<?php

namespace App\Form;

use App\DataFixtures\Groupe;
use App\Entity\Exam;
use App\Entity\Filiere;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class NotesAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           /* ->add('filiere', EntityType::class, [
                'class' => Filiere::class,
                'choice_label' => 'libelle',
                'attr'  => [
                    'class' => 'form-group form-control form-control-lg'
                ],
                'constraints'=>[
                    new NotBlank(),
                ]
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
            ->add('exam', EntityType::class, [
                'class' => Exam::class,
                'choice_label' => 'libelle',
                'attr'  => [
                    'class' => 'form-group form-control form-control-lg'
                ],
                'constraints'=>[
                    new NotBlank(),
                ]
            ])*/
            ->add('notes', CollectionType::class, array(
                'entry_type'   => NoteType::class,
                'allow_add'    => true,
                'allow_delete' => true
            ))
            ->add('save',      SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
