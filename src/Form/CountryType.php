<?php

namespace App\Form;

use App\Entity\Country;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CountryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'maxlength' => 2,
                ],
                'required' => true,
            ])
            ->add('nationality', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'maxlength' => 100,
                ],
                'required' => true,
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
            'data_class' => Country::class,
            'isEdit' => false,
        ]);
    }
}
