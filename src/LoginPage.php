<?php

namespace Tistre\SimpleOAuthLogin;


class LoginPage
{
    /** @var Login */
    protected $oauthLogin;

    /** @var Service */
    protected $oauthService;

    /** @var string */
    protected $redirectAfterLogin;

    /** @var callable */
    protected $authenticatedCallback;


    /**
     * LoginPage constructor.
     * @param Login $oauthLogin
     * @param string $service
     * @param string $redirectAfterLogin
     */
    public function __construct(Login $oauthLogin, $service, $redirectAfterLogin)
    {
        $this->oauthLogin = $oauthLogin;
        $this->oauthService = $this->oauthLogin->getService($service);
        $this->redirectAfterLogin = $redirectAfterLogin;
    }


    /**
     * @param callable $callback
     * @return void
     */
    public function setAuthenticatedCallback($callback)
    {
        $this->authenticatedCallback = $callback;
    }
    
    
    /**
     * @return void
     */
    public function processRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['code'])) {
                $this->onReturnFromService();
            } elseif (isset($_GET['error'])) {
                error_log(__METHOD__ . ': Service returned error: ' . print_r($_GET, true));
                echo "Error. See log file for details.\n";
            } else {
                $this->redirectToService();
            }
        } else {
            error_log(__METHOD__ . ': Unsupported request method ' . $_SERVER['REQUEST_METHOD']);
            echo "Error. See log file for details.\n";
        }
    }


    /**
     * @return void
     */
    protected function redirectToService()
    {
        $authorizationUrl = $this->oauthService->getAuthorizationUrl();

        // The OAuth library automatically generates a state value that we can
        // validate later. We just save it for now.

        $oAuthInfo = (new OAuthInfo($_SESSION['oauth_info']))
            ->setState($this->oauthService->getProvider()->getState())
            ->setRedirectAfterlogin($this->redirectAfterLogin);

        $_SESSION['oauth_info'] = $oAuthInfo->getArray();

        session_write_close();

        header('Location: ' . $authorizationUrl);
        exit();
    }


    /**
     * @return void
     */
    protected function onReturnFromService()
    {
        $oAuthInfo = new OAuthInfo($_SESSION['oauth_info']);

        // Validate the OAuth state parameter
        if (empty($_GET['state']) || ($_GET['state'] !== $oAuthInfo->getState())) {
            $oAuthInfo->setState('');
            $_SESSION['oauth_info'] = $oAuthInfo->getArray();
            session_write_close();
            error_log(__METHOD__ . ': State value does not match the one initially sent');
            echo "Error. See log file for details.\n";
            exit();
        }

        // With the authorization code, we can retrieve access tokens and other data.
        try {
            // Get an access token using the authorization code grant
            $accessToken = $this->oauthService->getAuthorizationCodeAccessToken($_GET['code']);

            // We got an access token, let's now get the user's details
            $userDetails = $this->oauthService->getUserDetails($accessToken);

            $oAuthInfo
                ->setAuthenticated(true)
                ->setProvider($this->oauthService->getService())
                ->setAccessToken($accessToken->getToken())
                ->setName($userDetails['name'])
                ->setMail($userDetails['mail'])
                ->setImage($userDetails['image'])
                ->setUrl($userDetails['url']);

            if (is_callable($this->authenticatedCallback)) {
                call_user_func($this->authenticatedCallback, $accessToken);
            }

            if (strlen($oAuthInfo->getRedirectAfterlogin()) > 0) {
                $this->redirectAfterLogin = $oAuthInfo->getRedirectAfterlogin();
            }

            $_SESSION['oauth_info'] = $oAuthInfo->getArray();
            session_write_close();

            header('Location: ' . $this->redirectAfterLogin);
            exit();
        } catch (League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            error_log(__METHOD__ . ': Something went wrong, couldn\'t get tokens: ' . $e->getMessage());
            echo "Error. See log file for details.\n";
        }
    }
}
