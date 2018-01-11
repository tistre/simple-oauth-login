<?php

namespace Tistre\SimpleOAuthLogin;


use League\OAuth2\Client\Provider\LinkedInResourceOwner;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class LinkedInService extends Service
{
    const SERVICE = Login::SERVICE_LINKEDIN;


    /**
     * @return \League\OAuth2\Client\Provider\LinkedIn
     */
    public function getProvider()
    {
        if (!$this->provider) {
            $this->provider = new \League\OAuth2\Client\Provider\LinkedIn($this->config->getProviderParams());
        }

        return $this->provider;
    }


    /**
     * @param ResourceOwnerInterface $user
     * @return array
     */
    protected function getUserDetailsFromResourceOwner(ResourceOwnerInterface $user)
    {
        $result = parent::getUserDetailsFromResourceOwner($user);

        if ($user instanceof LinkedInResourceOwner) {
            $result['name'] = $user->getFirstName() . ' ' . $user->getLastName();
            $result['mail'] = $user->getEmail();
            $result['image'] = $user->getImageurl();
            $result['url'] = $user->getUrl();
        }

        return $result;
    }


    /**
     * @return string
     */
    public function getLoginLinkText()
    {
        return 'Sign in with LinkedIn';
    }
}
