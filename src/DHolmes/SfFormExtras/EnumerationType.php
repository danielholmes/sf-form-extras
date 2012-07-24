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
            throw new \Exception('Not yet implemented');
            /*$builder
                ->addEventSubscriber(new MergeCollectionListener())
                ->prependClientTransformer(new EntitiesToArrayTransformer($options['choice_list']))
            ;*/
        }
        else
        {
            $transformer = new EnumerationDataTransformer($options['class']);
            $builder->appendNormTransformer($transformer);
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
            'choices'  => $choiceList
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