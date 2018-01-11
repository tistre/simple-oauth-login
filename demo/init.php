<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

session_name('oauth_demo');
session_start();

if (! isset($_SESSION['oauth_info'])) {
    $_SESSION['oauth_info'] = [];
}

if (! isset($_SESSION['oauth_info']['authenticated'])) {
    $_SESSION['oauth_info']['authenticated'] = false;
}

define('BASE_URL', '/oauth_demo/');

define('PAGE_URL', htmlspecialchars(preg_replace('|/+|', '/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))));

function oauth_login_if_not_authenticated()
{
    if ($_SESSION['oauth_info']['authenticated']) {
        return;
    }

    header('Location: ' . BASE_URL . 'oauth_login.php?redirect_after_login=' . urlencode(PAGE_URL));
    exit();
}
