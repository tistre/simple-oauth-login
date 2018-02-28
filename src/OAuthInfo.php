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

    protected $ARRAY_STRING_KEYS = [
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
    public function setArray($info)
    {
        if (!is_array($info)) {
            $info = [];
        }

        if (!isset($info['authenticated'])) {
            $info['authenticated'] = false;
        }

        $this->setAuthenticated(boolval($info['authenticated']));

        foreach ($this->ARRAY_STRING_KEYS as $key) {
            if (isset($info[$key])) {
                $this->$key = $info[$key];
            }
        }

        return $this;
    }


    /**
     * @return array
     */
    public function getArray()
    {
        $result = ['authenticated' => $this->authenticated];

        foreach ($this->ARRAY_STRING_KEYS as $key) {
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
    public function getState()
    {
        return $this->state;
    }


    /**
     * @param string $state
     * @return self
     */
    public function setState(string $state)
    {
        $this->state = $state;
        return $this;
    }


    /**
     * @return bool
     */
    public function isAuthenticated()
    {
        return $this->authenticated;
    }


    /**
     * @param bool $authenticated
     * @return self
     */
    public function setAuthenticated(bool $authenticated)
    {
        $this->authenticated = $authenticated;
        return $this;
    }


    /**
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }


    /**
     * @param string $provider
     * @return self
     */
    public function setProvider(string $provider)
    {
        $this->provider = $provider;
        return $this;
    }


    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }


    /**
     * @param string $accessToken
     * @return self
     */
    public function setAccessToken(string $access_token)
    {
        $this->access_token = $access_token;
        return $this;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }


    /**
     * @param string $mail
     * @return self
     */
    public function setMail(string $mail)
    {
        $this->mail = $mail;
        return $this;
    }


    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }


    /**
     * @param string $image
     * @return self
     */
    public function setImage(string $image)
    {
        $this->image = $image;
        return $this;
    }


    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }


    /**
     * @param string $url
     * @return self
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
        return $this;
    }


    /**
     * @return string
     */
    public function getRedirectAfterlogin()
    {
        return $this->redirect_after_login;
    }


    /**
     * @param string $redirectAfterLogin
     * @return self
     */
    public function setRedirectAfterlogin(string $redirect_after_login)
    {
        $this->redirect_after_login = $redirect_after_login;
        return $this;
    }
}