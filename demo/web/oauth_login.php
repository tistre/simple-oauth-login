<?php

use Tistre\SimpleOAuthLogin\Login;

require dirname(__DIR__) . '/init.php';


/**
 * @param Login $oauthLogin
 * @return string
 */
function getService(Login $oauthLogin)
{
    $service = '';
    $configuredServices = $oauthLogin->getConfiguredServices();

    if (!empty($_SERVER['PATH_INFO'])) {
        $service = basename($_SERVER['PATH_INFO']);
    } elseif (!empty($_COOKIE['oauth_provider'])) {
        $service = $_COOKIE['oauth_provider'];
    } elseif (count($configuredServices) === 1) {
        $service = $configuredServices[0];
    }

    if (!in_array($service, $configuredServices)) {
        $service = '';
    }

    return $service;
}


$redirectAfterLogin = BASE_URL;

if (isset($_REQUEST['redirect_after_login'])) {
    $redirectAfterLogin = Login::sanitizeRedirectUrl($_REQUEST['redirect_after_login']);
}

$oauthLogin = new Login();
$oauthLogin->addServiceConfigsFromArray($oauthConfigs);

$service = getService($oauthLogin);

if ($service) {
    setcookie('oauth_provider', $service, (time() + 86400 * 90), '', $_SERVER['HTTP_HOST'], true, true);

    $oauthLoginPage = new Tistre\SimpleOAuthLogin\LoginPage($oauthLogin, $service, $redirectAfterLogin);

    $oauthLoginPage->processRequest();

    session_write_close();
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Simple OAuth2 login demo</title>
    <link href="bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" media="screen"/>
</head>
<body>
<div class="container">

    <ul>
        <?php

        foreach ($oauthLogin->getConfiguredServices() as $service) {
            printf(
                '<li><a href="%s">%s</a></li>',
                htmlspecialchars(Login::getUrlWithService(BASE_URL . 'oauth_login.php', $oauthLogin->getService($service)->getLoginLinkText(), $redirectAfterLogin)),
                htmlspecialchars($oauthLogin->getService($service)->getLoginLinkText())
            );
        }

        ?>
    </ul>

</div>

<script src="jquery/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
