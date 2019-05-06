<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the public 'hateoas.event_subscriber.json' shared service.

include_once $this->targetDirs[3].'/vendor/jms/serializer/src/JMS/Serializer/EventDispatcher/EventSubscriberInterface.php';
include_once $this->targetDirs[3].'/vendor/willdurand/hateoas/src/Hateoas/Serializer/EventSubscriber/JsonEventSubscriber.php';
include_once $this->targetDirs[3].'/vendor/willdurand/hateoas/src/Hateoas/Serializer/JsonSerializerInterface.php';
include_once $this->targetDirs[3].'/vendor/willdurand/hateoas/src/Hateoas/Serializer/JsonHalSerializer.php';
include_once $this->targetDirs[3].'/vendor/willdurand/hateoas/src/Hateoas/Serializer/JMSSerializerMetadataAwareInterface.php';
include_once $this->targetDirs[3].'/vendor/willdurand/hateoas/src/Hateoas/Serializer/Metadata/InlineDeferrer.php';

$a = ${($_ = isset($this->services['jms_serializer.metadata_factory']) ? $this->services['jms_serializer.metadata_factory'] : $this->getJmsSerializer_MetadataFactoryService()) && false ?: '_'};

return $this->services['hateoas.event_subscriber.json'] = new \Hateoas\Serializer\EventSubscriber\JsonEventSubscriber(new \Hateoas\Serializer\JsonHalSerializer(), ${($_ = isset($this->services['hateoas.links_factory']) ? $this->services['hateoas.links_factory'] : $this->load('getHateoas_LinksFactoryService.php')) && false ?: '_'}, ${($_ = isset($this->services['hateoas.embeds_factory']) ? $this->services['hateoas.embeds_factory'] : $this->load('getHateoas_EmbedsFactoryService.php')) && false ?: '_'}, new \Hateoas\Serializer\Metadata\InlineDeferrer($a), new \Hateoas\Serializer\Metadata\InlineDeferrer($a));
