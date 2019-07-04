<?php

namespace App\Form;

use App\Entity\Award;
use App\Entity\AwardCategory;
use App\Entity\MovieAward;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieAwardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('award', EntityType::class, [
                'class' => Award::class,
                'choice_label' => function ($award) {
                    return $award->getName() . ' - ' . $award->getDescription();
                },
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
                'multiple' => false,
            ])
            ->add('award_category', EntityType::class, [
                'class' => AwardCategory::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
                'multiple' => false,
            ])
            ->add('type', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'maxlength' => 3,
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
            'data_class' => MovieAward::class,
            'isEdit' => false,
        ]);
    }
}
