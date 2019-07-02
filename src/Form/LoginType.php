<?php

namespace App\Form;

use App\Entity\Login;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'style' => 'color:white',
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'style' => 'color:white',
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'style' => 'color:white',
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Login',
                'attr' => [
                    'class' => 'btn btn-md btn-success float-right',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Login::class,
        ]);
    }
}
