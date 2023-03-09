<?php

namespace App\Form;

use App\Entity\Profil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProfilEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', TextType::class, [
                'attr' => [
                    'maxLength' => 50,
                ]
            ])
            ->add('firstName', TextType::class, [
                'attr' => [
                    'maxLength' => 50,
                ]
            ])
            ->add('title', TextType::class, [
                'attr' => [
                    'maxLength' => 100,
                ]
            ])
            ->add('image',FileType::class,[
                'required' => false,
                'mapped' => false,
                'help' => 'Image format jpg, jpeg, webp ou png - 2 Mo maximum',
                'constraints' => [
                    new Image([
                        'maxSize' => '2M',
                        'maxSizeMessage' => 'Le fichier est trop volumineux ({{ size }} {{ suffix }}). La taille maximale autorisée est de {{ limit }} {{ suffix }}',
                        'mimeTypesMessage' => 'Le type de fichier est invalide ({{ type }}). Les types autorisés sont {{ types }}',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/webp',
                            'image/png',
                        ],
                    ])
                ]
            ])
            ->add('shortPitch', TextType::class, [
                'attr' => [
                    'maxLength' => 255,
                ]
            ])
            ->add('description', TextareaType::class, [])
            ->add('hobby', TextType::class, [
                'attr' => [
                    'maxLength' => 255,
                ]
            ])
            ->add('submit',SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profil::class,
        ]);
    }
}
