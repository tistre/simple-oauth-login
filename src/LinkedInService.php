<?php

namespace Tistre\SimpleOAuthLogin;


class LinkedInService extends Service
{
    const SERVICE = Login::SERVICE_LINKEDIN;
        
    
    public function getProvider()
    {
        if (! $this->provider) {
            $this->provider = new \League\OAuth2\Client\Provider\LinkedIn($this->config->getProviderParams());
        }
        
        return $this->provider;
    }
    
    
    protected function getUserDetailsFromResourceOwner($user)
    {
        return [
            // LinkedIn user seems to have no getName() method
            'name' => $user->getFirstName() . ' ' . $user->getLastName(),
            'mail' => $user->getEmail()
        ];
    }
}
