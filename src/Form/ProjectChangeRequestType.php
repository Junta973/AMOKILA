<?php

namespace App\Form;

use App\Entity\ProjectChangeRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectChangeRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_de_creation')
            ->add('pcr_description')
            ->add('pcr_change_reason')
            ->add('impact_of_change')
            ->add('pcr_proposed_action')
            ->add('approval_date')
            ->add('pcr_status')
            ->add('pcr_name')
            ->add('pcr_ref')
            ->add('approved_by')
            ->add('Materials')
            ->add('Components')
            ->add('Request_by')
            ->add('Priority')
            ->add('Estimated_cost')
            ->add('user')
            ->add('project')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProjectChangeRequest::class,
        ]);
    }
}
