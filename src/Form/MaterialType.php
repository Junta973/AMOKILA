<?php

namespace App\Form;

use App\Entity\Material;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ref_material', TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('name_material', TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('date_validation_in', DateType::class,
                [
                    'label' => false,
                    'required' => false,
                    'mapped' => true,
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'attr' => [
                        'class' => 'form-control datepicker'
                    ]
                ])
            ->add('date_validation_out', DateType::class,
                [
                    'label' => false,
                    'required' => false,
                    'mapped' => true,
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'attr' => [
                        'class' => 'form-control datepicker'
                    ]
                ])
            ->add('material_cost', null,[
                'attr' => ['class' => 'form-control','min'=>0]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Material::class,
        ]);
    }
}
