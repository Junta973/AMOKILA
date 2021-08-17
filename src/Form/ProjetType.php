<?php

namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ref_project', TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('project_name', TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('project_description', TextareaType::class,[
                'attr' => ['class' => 'wc-100','rows'=>4]
            ])
            ->add('date_init_projet')
            ->add('date_fin_projet')
            ->add('cost', null,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('budget', null,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('maitre', null,[
                'attr' => ['class' => 'wc-100']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}