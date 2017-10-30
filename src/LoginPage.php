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
    
    
    public function __construct(Login $oauthLogin, $redirectAfterLogin)
    {
        $this->oauthLogin = $oauthLogin;
        $this->redirectAfterLogin = $redirectAfterLogin;
    }
    
    
    public function processRequest()
    {
        $this->chooseService();
        
        if (($_SERVER['REQUEST_METHOD'] === 'GET') && (! isset($_GET['code']))) {
            $this->redirectToService();
        } elseif (($_SERVER['REQUEST_METHOD'] === 'GET') && isset($_GET['code'])) {
            $this->onReturnFromService();
        }
    }
    
    
    protected function chooseService()
    {
        $service = false;
        $configuredServices = $this->oauthLogin->getConfiguredServices();
        
        if (! empty($_SERVER['PATH_INFO'])) {
            $service = basename($_SERVER['PATH_INFO']);
        } elseif (! empty($_COOKIE['oauth_provider'])) {
            $service = $_COOKIE['oauth_provider'];
        } elseif (count($configuredServices) === 1) {
            $service = $configuredServices[0];
        } 
        
        if ($service) {
            $this->oauthService = $this->oauthLogin->getService($service);
            
            setcookie('oauth_provider', $service, (time() + 86400 * 90), '', $_SERVER['HTTP_HOST'], true, true);        
        } else {
            echo "<ul>\n";
    
            foreach ($configuredServices as $service) {
                printf(
                    '<li><a href="%s">Sign in with %s</a></li>',
                    htmlspecialchars($this->getUrlWithService($service, $this->redirectAfterLogin)),
                    htmlspecialchars($service)
                );
            }
    
            echo "</ul>\n";
            
            session_write_close();
            exit;
        }
    }
    
    
    protected function getUrlWithService($service, $redirectAfterLogin)
    {
        return sprintf
        (
            '%s/%s?redirect_after_login=%s',
            $_SERVER['SCRIPT_NAME'],
            $service,
            urlencode($redirectAfterLogin)
        );
    }


    protected function redirectToService()
    {
        $authorizationUrl = $this->oauthService->getAuthorizationUrl();

        // The OAuth library automatically generates a state value that we can
        // validate later. We just save it for now.
        $_SESSION['oauth_info']['state'] = $this->oauthService->getProvider()->getState();
        $_SESSION['oauth_info']['redirect_after_login'] = $this->redirectAfterLogin;
    
        session_write_close();
    
        header('Location: ' . $authorizationUrl);
        exit();
    }
    
    
    protected function onReturnFromService()
    {
        // Validate the OAuth state parameter
        if (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth_info']['state'])) {
            unset($_SESSION['oauth_info']['state']);
            session_write_close();
            exit('State value does not match the one initially sent');
        }

        // With the authorization code, we can retrieve access tokens and other data.
        try {
            // Get an access token using the authorization code grant
            $accessToken = $this->oauthService->getAuthorizationCodeAccessToken($_GET['code']);
        
            $_SESSION['oauth_info']['authenticated'] = true;
            $_SESSION['oauth_info']['provider'] = $this->oauthService->getService();
            $_SESSION['oauth_info']['access_token'] = $accessToken->getToken();
        
            // We got an access token, let's now get the user's details
        
            $userDetails = $this->oauthService->getUserDetails($accessToken);
        
            $_SESSION['oauth_info']['name'] = $userDetails['name'];
            $_SESSION['oauth_info']['mail'] = $userDetails['mail'];

            if (! empty($_SESSION['oauth_info']['redirect_after_login'])) {
                $this->redirectAfterLogin = $_SESSION['oauth_info']['redirect_after_login'];
            }
        
            session_write_close();
        
            header('Location: ' . $this->redirectAfterLogin);
            exit();
        } catch (League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            echo 'Something went wrong, couldn\'t get tokens: ' . $e->getMessage();
        }
    }
}
