<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'csa_guzzle.client.facebook_api' shared service.

include_once $this->targetDirs[3].'/vendor/guzzlehttp/guzzle/src/ClientInterface.php';
include_once $this->targetDirs[3].'/vendor/guzzlehttp/guzzle/src/Client.php';

return $this->services['csa_guzzle.client.facebook_api'] = new \GuzzleHttp\Client(['base_url' => 'https://graph.facebook.com']);
