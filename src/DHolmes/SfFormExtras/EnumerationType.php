<?php

namespace DHolmes\SfFormExtras;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Options;

class EnumerationType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
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

    public function getDefaultOptions()
    {
        $choiceList = function (Options $options)
        {
            $class = $options['class'];
            return $class::getNamesByKey();
        };
        
        return array(
            'class'    => null,
            'property' => null,
            'choices'  => $choiceList
        );
    }

    public function getParent(array $options)
    {
        return 'choice';
    }

    public function getName()
    {
        return 'enumeration';
    }
}