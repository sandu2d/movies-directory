<?php

namespace App\Form;

use App\Entity\Country;
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
use Symfony\Component\Validator\Constraints\File;

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
                'data_class' => null,
                'required' => true,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid JPEG image',
                    ]),
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => $options['isEdit'] ? 'Save' : 'Add',
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
            'isEdit' => false,
        ]);
    }
}
