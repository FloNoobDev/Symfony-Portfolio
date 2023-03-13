<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName',TextType::class,[
                'required' => true,                
                'attr' => [
                    'maxLength' => 80
                ]
            ])
            ->add('firstName',TextType::class,[
                'required' => true,                
                'attr' => [
                    'maxLength' => 80
                ]
            ])
            ->add('email',EmailType::class,[
                'required' => true,                
                'attr' => [
                    'maxLength' => 180
                ]
            ])
            ->add('subject',ChoiceType::class,[
                'required' => true,                
                'choices' => [
                    'Projet' => 'Contact-Projet',
                    'Partenariat' => 'Contact-Partenariat',
                    'Autre' => 'Contact-Autre',
                ],
            ])
            ->add('message',TextareaType::class,[
                'required' => true,
            ])
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
