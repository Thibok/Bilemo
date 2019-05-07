<?php

/**
 * Normalizer for NotFoundHttpException
 */

namespace AppBundle\Normalizer;

use Symfony\Component\HttpFoundation\Response;

/**
 * NotFoundHttpExceptionNormalizer
 */
class NotFoundHttpExceptionNormalizer extends AbstractNormalizer
{
    /**
     * @inheritDoc
     */
    public function normalize(\Exception $exception)
    {
        if (!$this->supports($exception)) {
            return;
        }

        $result['code'] = 404;

        $result['body'] = [
            'code' => 404,
            'message' => 'This resource does not exist'
        ];

        return $result;
    }
}