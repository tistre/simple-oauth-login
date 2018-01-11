<?php

namespace Tistre\SimpleOAuthLogin;

use League\OAuth2\Client\Provider\GithubResourceOwner;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;


class GithubService extends Service
{
    const SERVICE = Login::SERVICE_GITHUB;


    /**
     * @return \League\OAuth2\Client\Provider\Github
     */
    public function getProvider()
    {
        if (!$this->provider) {
            $this->provider = new \League\OAuth2\Client\Provider\Github($this->config->getProviderParams());
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

        if ($user instanceof GithubResourceOwner) {
            $result['name'] = $user->getName();
            $result['mail'] = $user->getEmail();
            $result['url'] = $user->getUrl();
        }

        return $result;
    }


    /**
     * @return string
     */
    public function getLoginLinkText()
    {
        return 'Sign in with GitHub';
    }
}
