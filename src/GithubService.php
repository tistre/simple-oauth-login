<?php

namespace Tistre\SimpleOAuthLogin;


class GithubService extends Service
{
    const SERVICE = Login::SERVICE_GITHUB;


    /**
     * @return \League\OAuth2\Client\Provider\Github
     */
    public function getProvider()
    {
        if (! $this->provider) {
            $this->provider = new \League\OAuth2\Client\Provider\Github($this->config->getProviderParams());
        }
        
        return $this->provider;
    }
}
