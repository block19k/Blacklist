<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UsersType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                    'label' => 'Vartotojo vardas',
                    'attr' => array('class' => 'form-control')
                ))
            ->add('password', TextType::class, array(
                    'label' => 'Slaptažodis',
                    'attr' => array('class' => 'form-control')
                ))
            // ->add('roles', TextType::class, array(
            //         'label' => 'Rolė',
            //         'attr' => array('class' => 'form-control')
            //     ))
            ->add('email', TextType::class, array(
                    'label' => 'E-paštas',
                    'attr' => array('class' => 'form-control')
                ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Users'
        ));
    }
}
