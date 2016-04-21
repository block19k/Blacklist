<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
// Formos texttype reikėjo klases TextType::class
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class LinksType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                    'label' => 'Pavadinimas',
                    'attr' => array('class' => 'form-control')
                ))
            ->add('description', TextType::class, array(
                    'label' => 'Aprašymas',
                    'attr' => array('class' => 'form-control')
                ))
            ->add('link', TextType::class, array(
                    'label' => 'URL',
                    'attr' => array('class' => 'form-control')
                ))
            ->add('active', CheckboxType::class, array(
                    'label' => 'Patvirtintas',
                    'required' => false
                ))
            ->add('save', SubmitType::class, array('label' => 'Išsaugoti', 'attr' => array( 'class' => 'btn btn-success')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Links'
        ));
    }
}
