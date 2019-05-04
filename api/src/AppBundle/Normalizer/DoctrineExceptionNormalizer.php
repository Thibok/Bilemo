<?php

namespace AppBundle\Normalizer;

use Symfony\Component\HttpFoundation\Response;

class DoctrineExceptionNormalizer extends AbstractNormalizer
{
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