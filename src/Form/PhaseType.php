<?php

namespace App\Form;

use App\Entity\Phase;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('phase_name')
            ->add('phase_description')
            ->add('project_phase_date_start')
            ->add('project_phase_date_end')
            ->add('project')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Phase::class,
        ]);
    }
}
