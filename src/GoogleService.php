<?php

namespace Tistre\SimpleOAuthLogin;

use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;


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


    /**
     * @param ResourceOwnerInterface $user
     * @return array
     */
    protected function getUserDetailsFromResourceOwner(ResourceOwnerInterface $user)
    {
        $result = parent::getUserDetailsFromResourceOwner($user);

        if ($user instanceof GoogleUser) {
            $result['name'] = $user->getName();
            $result['mail'] = $user->getEmail();
            $result['image'] = $user->getAvatar();
        }

        return $result;
    }
}
