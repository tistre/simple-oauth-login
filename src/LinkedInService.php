<?php

namespace Tistre\SimpleOAuthLogin;


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
        return [
            // LinkedIn user seems to have no getName() method
            'name' => $user->getFirstName() . ' ' . $user->getLastName(),
            'mail' => $user->getEmail(),
            'url' => $user->getUrl()
        ];
    }
}
