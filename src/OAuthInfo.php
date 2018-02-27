<?php

namespace Tistre\SimpleOAuthLogin;


class OAuthInfo
{
    /** @var bool */
    protected $authenticated = false;

    /** @var string */
    protected $state = '';

    /** @var string */
    protected $provider = '';

    /** @var string */
    protected $access_token = '';

    /** @var string */
    protected $name = '';

    /** @var string */
    protected $mail = '';

    /** @var string */
    protected $image = '';

    /** @var string */
    protected $url = '';

    /** @var string */
    protected $redirect_after_login = '';

    const ARRAY_STRING_KEYS = [
        'state',
        'provider',
        'access_token',
        'name',
        'mail',
        'image',
        'url',
        'redirect_after_login'
    ];


    public function __construct($info)
    {
        $this->setArray($info);
    }


    /**
     * @param mixed $info
     * @return self
     */
    public function setArray($info): OAuthInfo
    {
        if (!is_array($info)) {
            $info = [];
        }

        if (!isset($info['authenticated'])) {
            $info['authenticated'] = false;
        }

        $this->setAuthenticated(boolval($info['authenticated']));

        foreach (self::ARRAY_STRING_KEYS as $key) {
            if (isset($info[$key])) {
                $this->$key = $info[$key];
            }
        }

        return $this;
    }


    /**
     * @return array
     */
    public function getArray(): array
    {
        $result = ['authenticated' => $this->authenticated];

        foreach (self::ARRAY_STRING_KEYS as $key) {
            $value = $this->$key;

            if (strlen($value) > 0) {
                $result[$key] = $value;
            }
        }

        return $result;
    }


    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }


    /**
     * @param string $state
     * @return self
     */
    public function setState(string $state): OAuthInfo
    {
        $this->state = $state;
        return $this;
    }


    /**
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return $this->authenticated;
    }


    /**
     * @param bool $authenticated
     * @return self
     */
    public function setAuthenticated(bool $authenticated): OAuthInfo
    {
        $this->authenticated = $authenticated;
        return $this;
    }


    /**
     * @return string
     */
    public function getProvider(): string
    {
        return $this->provider;
    }


    /**
     * @param string $provider
     * @return self
     */
    public function setProvider(string $provider): OAuthInfo
    {
        $this->provider = $provider;
        return $this;
    }


    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->access_token;
    }


    /**
     * @param string $accessToken
     * @return self
     */
    public function setAccessToken(string $access_token): OAuthInfo
    {
        $this->access_token = $access_token;
        return $this;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name): OAuthInfo
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }


    /**
     * @param string $mail
     * @return self
     */
    public function setMail(string $mail): OAuthInfo
    {
        $this->mail = $mail;
        return $this;
    }


    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }


    /**
     * @param string $image
     * @return self
     */
    public function setImage(string $image): OAuthInfo
    {
        $this->image = $image;
        return $this;
    }


    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }


    /**
     * @param string $url
     * @return self
     */
    public function setUrl(string $url): OAuthInfo
    {
        $this->url = $url;
        return $this;
    }


    /**
     * @return string
     */
    public function getRedirectAfterlogin(): string
    {
        return $this->redirect_after_login;
    }


    /**
     * @param string $redirectAfterLogin
     * @return self
     */
    public function setRedirectAfterlogin(string $redirect_after_login): OAuthInfo
    {
        $this->redirect_after_login = $redirect_after_login;
        return $this;
    }
}