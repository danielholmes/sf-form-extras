<?php

namespace DHolmes\SfFormExtras;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EnumerationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['multiple'])
        {
            $builder->appendNormTransformer(new EnumerationArrayDataTransformer($options['class']));
        }
        else
        {
            $builder->appendNormTransformer(new EnumerationDataTransformer($options['class']));
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $choiceList = function (Options $options)
        {
            $class = $options['class'];
            return $class::getNamesByKey();
        };
        
        $resolver->setDefaults(array(
            'class'    => null,
            'property' => null,
            'choices'  => $choiceList,
            'label_property' => 'name'
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'enumeration';
    }
}