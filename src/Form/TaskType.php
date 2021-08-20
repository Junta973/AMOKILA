<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('task_ref', TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('task_name', TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('task_description', TextareaType::class,[
                'attr' => ['class' => 'wc-100','rows'=>4]
            ])
            ->add('date', DateType::class,
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
            ->add('date_start', DateType::class,
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
            ->add('date_end', DateType::class,
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
            ->add('progress', null,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('task_cost', null,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('requestChange', null,[
                'attr' => ['class' => 'wc-100']
            ])
            ->add('user', null,[
                'attr' => ['class' => 'wc-100']
            ])
            ->add('projet', null,[
                'attr' => ['class' => 'wc-100']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
