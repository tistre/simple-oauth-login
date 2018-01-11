<?php

require dirname(__DIR__) . '/init.php';

if ($_SESSION['oauth_info']['authenticated']) {
    $_SESSION['oauth_info'] = ['authenticated' => false];
    session_write_close();
}

header('Location: ' . BASE_URL);
