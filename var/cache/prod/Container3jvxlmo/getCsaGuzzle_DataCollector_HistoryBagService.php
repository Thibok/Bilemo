<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'csa_guzzle.data_collector.history_bag' shared service.

include_once $this->targetDirs[3].'/vendor/csa/guzzle-bundle/src/GuzzleHttp/History/History.php';

return $this->services['csa_guzzle.data_collector.history_bag'] = new \Csa\Bundle\GuzzleBundle\GuzzleHttp\History\History();