<?php

namespace AA\EuroMillionsBundle\Form;

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
            ->add('number1')
            ->add('number2')
            ->add('number3')
            ->add('number4')
            ->add('number5')
            ->add('star1')
            ->add('star2')
            ->add('date')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AA\EuroMillionsBundle\Entity\Draw'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'aa_EuroMillionsbundle_draw';
    }
}
