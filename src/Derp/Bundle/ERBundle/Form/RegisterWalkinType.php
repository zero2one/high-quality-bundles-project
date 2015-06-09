<?php

namespace Derp\Bundle\ERBundle\Form;

use Derp\Bundle\ERBundle\Entity\Sex;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Derp\Command\RegisterWalkin;

class RegisterWalkinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', 'text', ['label' => 'First name (if you don\'t know: John, Jane, ...)'])
            ->add('lastName', 'text', ['label' => 'Last name (if you don\'t know: Doe, Roe, ...)'])

            ->add(
                'sex',
                'choice',
                [
                    'choices' => [Sex::MALE => 'Male', Sex::FEMALE => 'Female', Sex::INTERSEX => 'Intersex']
                ]
            )

            ->add(
                'birthDate',
                'date',
                [
                    'label' => 'Date of birth (if you don\'t know, guess)',
                    'years' => range(date('Y'), date('Y') - 120)
                ]
            )

            ->add('indication', 'textarea', ['label' => 'Indication', 'attr' => ['rows' => 5, 'cols' => 20]])

            ->add('submit', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RegisterWalkin::class
        ]);
    }

    public function getName()
    {
        return 'register_walk_in';
    }
}
