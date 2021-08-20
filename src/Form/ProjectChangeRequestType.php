<?php

namespace App\Form;

use App\Entity\ProjectChangeRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectChangeRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_de_creation', DateType::class,
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
            ->add('pcr_description', TextareaType::class,[
                'attr' => ['class' => 'wc-100','rows'=>3]
            ])
            ->add('pcr_change_reason', TextareaType::class,[
                'attr' => ['class' => 'wc-100','rows'=>3]
            ])
            ->add('impact_of_change', TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('pcr_proposed_action', TextareaType::class,[
                'attr' => ['class' => 'wc-100','rows'=>3]
            ])
            ->add('pcr_status', ChoiceType::class,[
                'attr' => ['class' => 'wc-100'],
                'choices' => [
                    'New CR' => 'New CR',
                    'In Review' => 'In Review',
                    'Approuved' => 'Approuved',
                    'Rejected' => 'Rejected'
                ],
                'required' => true,
            ])
            ->add('pcr_name', TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('pcr_ref', TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('Materials', null,[
                'attr' => ['class' => 'wc-100']
            ])
            ->add('Components', null,[
                'attr' => ['class' => 'wc-100']
            ])
            ->add('Priority', ChoiceType::class,[
                'attr' => ['class' => 'wc-100'],
                'choices' => [
                    'Low' => 'Low',
                    'Medium' => 'Medium',
                    'Hight' => 'Hight',
                ],
                'required' => true
            ])
            ->add('Estimated_cost', null,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('user', null,[
                'attr' => ['class' => 'wc-100']
            ])
            ->add('project', null,[
                'attr' => ['class' => 'wc-100']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProjectChangeRequest::class,
        ]);
    }
}
