<?php

namespace DHolmes\SfFormExtras;

use InvalidArgumentException;
use Symfony\Component\Form\DataTransformerInterface;

class NumberMagnitudeDataTransformer implements DataTransformerInterface
{
    /** @var string */
    private $magnitude;
    
    /**
     *
     * @param double $magnitude 
     */
    public function __construct($magnitude)
    {
        $this->magnitude = $magnitude;
        if (!is_numeric($this->magnitude))
        {
            throw new InvalidArgumentException('Magnitude must be a numeric value');
        }
        else if ($this->magnitude === 0)
        {
            throw new InvalidArgumentException('Magnitude cannot be 0');
        }
    }
    
    /**
     *
     * @param mixed $value
     * @return string 
     */
    public function transform($value)
    {
        $newValue = $value;
        if (ctype_digit($value))
        {
            $newValue = $value * $this->magnitude;
        }
        
        return $newValue;
    }
    
    /**
     *
     * @param string $value
     * @return array
     */
    public function reverseTransform($value)
    {
        $newValue = $value;
        if (ctype_digit($value))
        {
            $newValue = $value / $this->magnitude;
        }
        
        return $newValue;
    }
}