<?php

/**
 * Listener for kernel.exception event
 */

namespace AppBundle\EventListener;

use JMS\Serializer\Serializer;
use AppBundle\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * ExceptionListener
 */
class ExceptionListener
{
    /**
     * @var Serializer
     * @access private
     */
    private $serializer;

    /**
     * @var array
     * @access private
     */
    private $normalizers;

    /**
     * Constructor
     * @access public
     * @param Serializer $serializer
     * 
     * @return void
     */
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * On Kernel Exception
     * @access public
     * @param GetResponseForExceptionEvent $event
     * 
     * @return void
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $result = null;

        foreach ($this->normalizers as $normalizer) {
            if ($normalizer->supports($event->getException())) {
                $result = $normalizer->normalize($event->getException());
                
                break;
            }
        }
        
        if (null == $result) {
            return;
        }

        $body = $this->serializer->serialize($result['body'], 'json');

        $event->setResponse(new Response($body, $result['code']));
    }

    /**
     * Add Normalizer
     * @access public
     * @param NormalizerInterface $normalizer
     * 
     * @return void
     */
    public function addNormalizer(NormalizerInterface $normalizer)
    {
        $this->normalizers[] = $normalizer;
    }
}