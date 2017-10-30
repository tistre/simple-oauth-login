<?php

namespace Tistre\SimpleOAuthLogin;


class ServiceConfig
{    
    protected $service = '';
    protected $providerParams = [];
    protected $authorizationUrlParams = [];
    
    
    public function isValid()
    {
        return (strlen($this->service) > 0);
    }
    
    
    public function getService()
    {
        return $this->service;
    }
    
    
    public function setService($service)
    {
        if (! defined('\\Tistre\\SimpleOAuthLogin\\Login::SERVICE_' . strtoupper($service))) {
            throw new \InvalidArgumentException("Undefined service '$service'");
        }
        
        $this->service = $service;
        
        return $this;
    }
    
    
    public function getProviderParams()
    {
        return $this->providerParams;
    }
    
    
    public function setProviderParams(array $params)
    {
        $this->providerParams = $params;
        
        return $this;
    }
    
    
    public function getAuthorizationUrlParams()
    {
        return $this->authorizationUrlParams;
    }
    
    
    public function setAuthorizationUrlParams(array $params)
    {
        $this->authorizationUrlParams = $params;
        
        return $this;
    }
}
