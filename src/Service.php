<?php

namespace Tistre\SimpleOAuthLogin;


abstract class Service
{
    /** @var Login */
    protected $oauthLogin;
    
    /** @var ServiceConfig */
    protected $config;
    
    protected $provider;
    
    protected $accessToken;

    abstract public function getProvider();
    
    
    public function __construct(Login $oauthLogin)
    {
        $this->oauthLogin = $oauthLogin;
        $this->config = $this->oauthLogin->getServiceConfig($this->getService());
    }
    

    public function getService()
    {
        return $this::SERVICE;
    }
    
    
    public function getConfig()
    {
        return $this->config;
    }
            

    public function getAuthorizationUrl()
    {
        return $this->getProvider()->getAuthorizationUrl($this->getConfig()->getAuthorizationUrlParams());
    }

    
    public function getAuthorizationCodeAccessToken($code)
    {
        if (! $this->accessToken) {
            $this->accessToken = $this->getProvider()->getAccessToken('authorization_code', ['code' => $code]);
        }
        
        return $this->accessToken;
    }
    
    
    public function getUserDetails($accessToken)
    {
        $user = $this->getProvider()->getResourceOwner($accessToken);

        return $this->getUserDetailsFromResourceOwner($user);
    }
    
    
    protected function getUserDetailsFromResourceOwner($user)
    {
        return [
            'name' => $user->getName(),
            'mail' => $user->getEmail()
        ];
    }
}
