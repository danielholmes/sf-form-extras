<?php

namespace DHolmes\SfFormExtras;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EnumerationType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        if ($options['multiple']) {
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
        $defaultOptions = array(
            'class'    => null,
            'property' => null,
            'choices'  => null
        );

        $options = array_replace($defaultOptions, $options);
        
        // TODO: Implement "property" instead of getNamesByKey
        
        if ($options['class'] === null)
        {
            throw new \RuntimeException('"class" required for enumeration type');
        }
        
        if (!isset($options['choices']))
        {
            $class = $options['class'];
            $defaultOptions['choices'] = $class::getNamesByKey();
        }

        return $defaultOptions;
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