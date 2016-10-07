<?php

namespace mysiar\Bundle\InvoiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class InvoiceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('invoiceNumber')
            ->add('dateOfIssue', DateType::class,
                array('widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'placeholder' => 'yyyy-MM-dd'
                )
            )
            ->add('dateOfSell', DateType::class,  array('widget' => 'choice') )
            ->add('paymentDue', DateType::class,  array('widget' => 'choice') )
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'mysiar\Bundle\InvoiceBundle\Entity\Invoice'
        ));
    }
}