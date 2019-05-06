<?php

/**
 * Interface for Normalizer
 */

namespace AppBundle\Normalizer;

/**
 * NormalizerInterface
 */
interface NormalizerInterface
{
    /**
     * Normalize exception
     * @access public
     * @param \Exception $exception
     * 
     * @return mixed array | void
     */
    public function normalize(\Exception $exception);

    /**
     * Check if exception is supported
     * @access public
     * @param \Exception $exception
     * 
     * @return boolean
     */
    public function supports(\Exception $exception);
}