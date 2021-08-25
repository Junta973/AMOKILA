<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,[
                'attr' => ['class' => 'form-control']
            ])
            //->add('roles')
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'form-control password-field']],
                'required' => true,
                'first_options'  => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmez mot de passe',
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ],
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('username', TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('name', TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('firstname', TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('age', null,[
                'attr' => ['class' => 'form-control','min'=>0]
            ])
            ->add('profession', TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('skills', TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('contrat', TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('departement', TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('hourly_fee', null,[
                'attr' => ['class' => 'form-control','min'=>0]
            ])
            ->add('level', null,[
                'attr' => ['class' => 'form-control','min'=>0,'max'=>5]
            ])
            ->add('avatar', MediaType::class)
            ->add('roles', ChoiceType::class, array(
                    'attr' => ['class' => ''],
                    'choices' =>
                        array
                        (
                            'Super Administrator' => 'ROLE_SUPER_ADMIN',
                            'Administrator' => 'ROLE_ADMIN',
                            'Utilisateur' => 'ROLE_USER'
                        ),
                    'multiple' => true,
                    'required' => true,
                    'expanded' => false,
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
