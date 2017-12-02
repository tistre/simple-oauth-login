<?php

namespace Tistre\SimpleOAuthLogin;


class Login
{
    const SERVICE_GITHUB = 'github';
    const SERVICE_GOOGLE = 'google';
    const SERVICE_LINKEDIN = 'linkedin';
    const SERVICE_MICROSOFT = 'microsoft';

    /** @var ServiceConfig[] */
    protected $serviceConfigs = [];


    /**
     * @param array $configs
     * @return self
     */
    public function addServiceConfigsFromArray(array $configs)
    {
        foreach ($configs as $service => $config) {
            $serviceConfig = new ServiceConfig();

            $serviceConfig->setService($service);
            $serviceConfig->setProviderParams($config['providerParams']);

            if (!empty($config['authorizationUrlParams'])) {
                $serviceConfig->setAuthorizationUrlParams($config['authorizationUrlParams']);
            }

            $this->addServiceConfig($serviceConfig);
        }

        return $this;
    }


    /**
     * @param ServiceConfig $serviceConfig
     * @return self
     */
    public function addServiceConfig(ServiceConfig $serviceConfig)
    {
        if (!$serviceConfig->isValid()) {
            throw new \InvalidArgumentException("Invalid service configuration");
        }

        $this->serviceConfigs[$serviceConfig->getService()] = $serviceConfig;

        return $this;
    }


    /**
     * @param string $service
     * @return ServiceConfig
     */
    public function getServiceConfig($service)
    {
        if (!isset($this->serviceConfigs[$service])) {
            throw new \InvalidArgumentException("Undefined service '$service'");
        }

        return $this->serviceConfigs[$service];
    }


    /**
     * @return string[]
     */
    public function getConfiguredServices()
    {
        return array_keys($this->serviceConfigs);
    }


    /**
     * @param string $service
     * @return Service
     */
    public function getService($service)
    {
        if ($service === self::SERVICE_GITHUB) {
            $service = new GithubService($this);
        } elseif ($service === self::SERVICE_GOOGLE) {
            $service = new GoogleService($this);
        } elseif ($service === self::SERVICE_LINKEDIN) {
            $service = new LinkedInService($this);
        } elseif ($service === self::SERVICE_MICROSOFT) {
            $service = new MicrosoftService($this);
        } else {
            throw new \InvalidArgumentException("Service '$service' not implemented");
        }

        return $service;
    }
}
