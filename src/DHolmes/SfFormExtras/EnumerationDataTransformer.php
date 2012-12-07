<?php

namespace DHolmes\SfFormExtras;

use Symfony\Component\Form\DataTransformerInterface;
use DHolmes\LangExtras\Enumeration;

class EnumerationDataTransformer implements DataTransformerInterface
{
    /** @var string */
    private $enumerationClass;
    
    /**
     * @param string $enumerationClass
     * @throws \InvalidArgumentException
     */
    public function __construct($enumerationClass)
    {
        if (is_subclass_of($enumerationClass, Enumeration::getClassName()))
        {
            $this->enumerationClass = $enumerationClass;
        }
        else
        {
            throw new \InvalidArgumentException(sprintf('class "%s" not a subclass of "%s"',
                $enumerationClass, Enumeration::getClassName()));
        }
    }
    
    /**
     * @param mixed $value
     * @return string 
     */
    public function transform($value)
    {
        $stringValue = null;
        if ($value instanceof $this->enumerationClass)
        {
            $stringValue = $value->getKey();
        }
        
        return $stringValue;
    }
    
    /**
     * @param string $value
     * @return Enumeration
     */
    public function reverseTransform($value)
    {
        $enumValue = null;
        $has = call_user_func_array(array($this->enumerationClass, 'has'), array($value));
        if ($has)
        {
            $enumValue = call_user_func_array(array($this->enumerationClass, 'get'), array($value));
        }
        
        return $enumValue;
    }
}