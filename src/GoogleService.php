<?php

namespace Tistre\SimpleOAuthLogin;


class GoogleService extends Service
{
    const SERVICE = Login::SERVICE_GOOGLE;
        
    
    public function getProvider()
    {
        if (! $this->provider) {
            $this->provider = new \League\OAuth2\Client\Provider\Google($this->config->getProviderParams());
        }
        
        return $this->provider;
    }
}
