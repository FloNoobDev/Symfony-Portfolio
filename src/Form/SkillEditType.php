<?php

namespace App\Form;

use App\Entity\Skill;
use App\Entity\SkillCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SkillEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr'=>[
                    'minLength'=>1,
                    'maxLength'=>45,
                ]
            ])
            ->add('image', FileType::class, [
                'required' => false,
                'mapped' => false,
                'help' => 'Image format jpg, jpeg, webp ou png - 1 Mo maximum',
                'constraints' => [
                    new Image([
                        'maxSize' => '1M',
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
            
            ->add('seniority', IntegerType::class, [
                'attr' => [
                    'min' => 1,
                    'step' => 1
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => SkillCategory::class,
                'choice_label' => 'name',
            ])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Skill::class,
        ]);
    }
}
