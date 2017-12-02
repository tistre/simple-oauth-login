<?php

namespace Tistre\SimpleOAuthLogin;


class ServiceConfig
{
    /** @var string */
    protected $service = '';

    /** @var array */
    protected $providerParams = [];

    /** @var array */
    protected $authorizationUrlParams = [];


    /**
     * @return bool
     */
    public function isValid()
    {
        return (strlen($this->service) > 0);
    }
    

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }


    /**
     * @param string $service
     * @return self
     */
    public function setService($service)
    {
        if (!defined('\\Tistre\\SimpleOAuthLogin\\Login::SERVICE_' . strtoupper($service))) {
            throw new \InvalidArgumentException("Undefined service '$service'");
        }

        $this->service = $service;

        return $this;
    }


    /**
     * @return array
     */
    public function getProviderParams()
    {
        return $this->providerParams;
    }


    /**
     * @param array $params
     * @return self
     */
    public function setProviderParams(array $params)
    {
        $this->providerParams = $params;

        return $this;
    }


    /**
     * @return array
     */
    public function getAuthorizationUrlParams()
    {
        return $this->authorizationUrlParams;
    }


    /**
     * @param array $params
     * @return self
     */
    public function setAuthorizationUrlParams(array $params)
    {
        $this->authorizationUrlParams = $params;

        return $this;
    }
}
