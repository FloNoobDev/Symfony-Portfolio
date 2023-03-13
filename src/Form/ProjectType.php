<?php

namespace App\Form;

use App\Entity\Skill;
use App\Entity\Project;
use App\Entity\ProjectCategory;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'maxLength' => 80
                ]
            ])

            ->add('description', TextareaType::class, [
                'required' => false,
            ])

            ->add('started_at', DateType::class, [
                'widget' => 'single_text',
                'mapped' => false,
            ])

            ->add('shortText', TextType::class, [
                'attr' => [
                    'maxLength' => 50
                ]
            ])

            ->add('environment', TextType::class, [
                'attr' => [
                    'maxLength' => 50
                ]
            ])

            ->add('link', TextType::class, [
                'attr' => [
                    'maxLength' => 100,
                ]
            ])

            ->add('icon', TextType::class, [
                'attr' => [
                    'maxLength' => 255,
                ]
            ])

            ->add('category', EntityType::class, [
                'class' => ProjectCategory::class,
                'choice_label' => 'name',
            ])

            ->add('skill', EntityType::class, [
                'class' => Skill::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])

            ->add('displayOnIndex')

            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
