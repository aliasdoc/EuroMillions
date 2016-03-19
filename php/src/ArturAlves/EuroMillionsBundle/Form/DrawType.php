<?php

namespace ArturAlves\EuroMillionsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DrawType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('result')
            ->add('date')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ArturAlves\EuroMillionsBundle\Entity\Draw'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'artur_alves_euro_millionsbundle_draw';
    }
}
