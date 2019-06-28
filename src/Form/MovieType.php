<?php

namespace App\Form;

use App\Entity\Actor;
use App\Entity\Country;
use App\Entity\Director;
use App\Entity\Genre;
use App\Entity\Language;
use App\Entity\Movie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
            ])
            ->add('year', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
            ])
            ->add('imdb_rate', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'html5' => true,
                'required' => true,
            ])
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'code',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
            ])
            ->add('box_office', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
            ])
            ->add('genre', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
            ])
            ->add('actors', EntityType::class, [
                'class' => Actor::class,
                'choice_label' => function ($actor) {
                    return $actor->getFirstName() . ' ' . $actor->getLastName();
                },
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
                'multiple' => true,
            ])
            ->add('directors', EntityType::class, [
                'class' => Director::class,
                'choice_label' => function ($director) {
                    return $director->getFirstName() . ' ' . $director->getLastName();
                },
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
                'multiple' => true,
            ])
            ->add('language', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
            ])
            ->add('poster', FileType::class, [
                'multiple' => false,
                'attr' => [
                    'class' => 'form-control-file',
                ],
                'required' => true,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Add',
                'attr' => [
                    'class' => 'btn btn-md btn-success float-right',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
