<?php

/**
 * Abstract class for Normalizer
 */

namespace AppBundle\Normalizer;

/**
 * AbstractNormalizer
 */
abstract class AbstractNormalizer implements NormalizerInterface
{
    /**
     * Array of Exception types supported by Normalizer
     * @var array
     * @access private
     */
    protected $exceptionTypes;

    /**
     * Constructor
     * @access public
     * @param array $exceptionTypes
     * 
     * @return void
     */
    public function __construct(array $exceptionTypes)
    {
        $this->exceptionTypes = $exceptionTypes;
    }

    /**
     * @inheritDoc
     */
    public function supports(\Exception $exception)
    {
        return in_array(get_class($exception), $this->exceptionTypes);
    }
}