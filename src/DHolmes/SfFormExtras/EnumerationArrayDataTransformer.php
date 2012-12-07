<?php

namespace DHolmes\SfFormExtras;

use Symfony\Component\Form\DataTransformerInterface;
use DHolmes\LangExtras\Enumeration;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

class EnumerationArrayDataTransformer implements DataTransformerInterface
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
     * @param array $array
     * @return array|mixed
     * @throws UnexpectedTypeException
     */
    public function transform($array)
    {
        $keys = array();
        if ($array !== null)
        {
            if (is_array($array))
            {
                foreach ($array as $enum)
                {
                    if ($enum instanceof $this->enumerationClass)
                    {
                        $keys[] = $enum->getKey();
                    }
                    else
                    {
                        throw new UnexpectedTypeException($enum, $this->enumerationClass);
                    }
                }
            }
            else
            {
                throw new UnexpectedTypeException($array, 'array');
            }
        }

        return $keys;
    }

    /**
     * @param array $array
     * @return array
     * @throws UnexpectedTypeException
     */
    public function reverseTransform($array)
    {
        $enums = array();
        if ($array !== null)
        {
            if (is_array($array))
            {
                foreach ($array as $key)
                {
                    $has = call_user_func_array(array($this->enumerationClass, 'has'), array($key));
                    if ($has)
                    {
                        $enums[] = call_user_func_array(array($this->enumerationClass, 'get'), array($key));
                    }
                    else
                    {
                        throw new UnexpectedTypeException($key, $this->enumerationClass);
                    }
                }
            }
            else
            {
                throw new UnexpectedTypeException($array, 'array');
            }
        }

        return $enums;
    }
}