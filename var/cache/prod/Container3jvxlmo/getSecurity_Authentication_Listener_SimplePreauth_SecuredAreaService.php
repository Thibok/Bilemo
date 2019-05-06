<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'security.authentication.listener.simple_preauth.secured_area' shared service.

include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Http/Firewall/ListenerInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Http/Firewall/SimplePreAuthenticationListener.php';
include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Http/Session/SessionAuthenticationStrategyInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Http/Session/SessionAuthenticationStrategy.php';

$this->services['security.authentication.listener.simple_preauth.secured_area'] = $instance = new \Symfony\Component\Security\Http\Firewall\SimplePreAuthenticationListener(${($_ = isset($this->services['security.token_storage']) ? $this->services['security.token_storage'] : ($this->services['security.token_storage'] = new \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage())) && false ?: '_'}, ${($_ = isset($this->services['security.authentication.manager']) ? $this->services['security.authentication.manager'] : $this->getSecurity_Authentication_ManagerService()) && false ?: '_'}, 'secured_area', ${($_ = isset($this->services['AppBundle\\Authenticator\\FacebookAuthenticator']) ? $this->services['AppBundle\\Authenticator\\FacebookAuthenticator'] : $this->load('getFacebookAuthenticatorService.php')) && false ?: '_'}, ${($_ = isset($this->services['monolog.logger.security']) ? $this->services['monolog.logger.security'] : $this->load('getMonolog_Logger_SecurityService.php')) && false ?: '_'}, ${($_ = isset($this->services['event_dispatcher']) ? $this->services['event_dispatcher'] : $this->getEventDispatcherService()) && false ?: '_'});

$instance->setSessionAuthenticationStrategy(${($_ = isset($this->services['security.authentication.session_strategy.secured_area']) ? $this->services['security.authentication.session_strategy.secured_area'] : ($this->services['security.authentication.session_strategy.secured_area'] = new \Symfony\Component\Security\Http\Session\SessionAuthenticationStrategy('none'))) && false ?: '_'});

return $instance;