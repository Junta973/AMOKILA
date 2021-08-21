<?php

namespace App\Form;

use App\Entity\Process;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProcessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ref_process', TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('process_name', TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('process_indice', TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('task', null,[
                'attr' => ['class' => 'wc-100']
            ])
            ->add('user', null,[
                'attr' => ['class' => 'wc-100']
            ])
            ->add('process_path', MediaType::class)
            ->add('document1_path', MediaType::class,['required'=>false])
            ->add('document2_path', MediaType::class,['required'=>false])
            ->add('document3_path', MediaType::class,['required'=>false])
            ->add('document4_path', MediaType::class,['required'=>false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Process::class,
        ]);
    }
}
