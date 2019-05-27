<?php

/**
 * Normalizer for Doctrine Exception
 */

namespace AppBundle\Normalizer;

use Symfony\Component\HttpFoundation\Response;

/**
 * DoctrineExceptionNormalizer
 */
class DoctrineExceptionNormalizer extends AbstractNormalizer
{
    /**
     * @inheritDoc
     */
    public function normalize(\Exception $exception)
    {
        if (!$this->supports($exception)) {
            return;
        }

        $result['code'] = 500;

        $result['body'] = [
            'code' => 500,
            'message' => 'An error is occured with the server'
        ];

        return $result;
    }
}