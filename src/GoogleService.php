<?php

namespace Tistre\SimpleOAuthLogin;


class GoogleService extends Service
{
    const SERVICE = Login::SERVICE_GOOGLE;


    /**
     * @return \League\OAuth2\Client\Provider\Google
     */
    public function getProvider()
    {
        if (!$this->provider) {
            $this->provider = new \League\OAuth2\Client\Provider\Google($this->config->getProviderParams());
        }

        return $this->provider;
    }


    /**
     * @return string
     */
    public function getLoginLinkText()
    {
        return 'Sign in with Google';
    }
}
