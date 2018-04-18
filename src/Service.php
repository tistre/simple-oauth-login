<?php

namespace Tistre\SimpleOAuthLogin;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;


abstract class Service
{
    /** @var Login */
    protected $oauthLogin;

    /** @var ServiceConfig */
    protected $config;

    /** @var object */
    protected $provider;

    /** @var AccessToken */
    protected $accessToken;


    /**
     * @return object
     */
    abstract public function getProvider();


    /**
     * Service constructor.
     * @param Login $oauthLogin
     */
    public function __construct(Login $oauthLogin)
    {
        $this->oauthLogin = $oauthLogin;
        $this->config = $this->oauthLogin->getServiceConfig($this->getService());
    }


    /**
     * @return string
     */
    public function getService()
    {
        return $this::SERVICE;
    }


    /**
     * @return ServiceConfig
     */
    public function getConfig()
    {
        return $this->config;
    }


    /**
     * @return string
     */
    public function getLoginLinkText()
    {
        return sprintf('Sign in with %s', $this::SERVICE);
    }


    /**
     * @return string
     */
    public function getAuthorizationUrl()
    {
        return $this->getProvider()->getAuthorizationUrl($this->getConfig()->getAuthorizationUrlParams());
    }


    /**
     * @param $code
     * @return AccessToken
     */
    public function getAuthorizationCodeAccessToken($code)
    {
        if (!$this->accessToken) {
            $this->accessToken = $this->getProvider()->getAccessToken('authorization_code', ['code' => $code]);
        }

        return $this->accessToken;
    }


    /**
     * @param AccessToken $accessToken
     * @return array
     */
    public function getUserDetails(AccessToken $accessToken)
    {
        $user = $this->getProvider()->getResourceOwner($accessToken);

        return $this->getUserDetailsFromResourceOwner($user);
    }


    /**
     * @param ResourceOwnerInterface $user
     * @return array
     */
    protected function getUserDetailsFromResourceOwner(ResourceOwnerInterface $user)
    {
        return [
            'name' => '',
            'mail' => '',
            'image' => '',
            'url' => ''
        ];
    }


    /**
     * @param AccessToken $accessToken
     * @return array
     */
    public function getUserGroups(AccessToken $accessToken)
    {
        return [];
    }
}
