<?php

$oauthLogin = new \Tistre\SimpleOAuthLogin\Login();
$oauthLogin->addServiceConfigsFromArray($oauthConfigs);

?>
<p>
    <small>
        <?php if ($_SESSION['oauth_info']['authenticated']) { ?>
            <?php if ($_SESSION['oauth_info']['image']) { ?><img src="<?=htmlspecialchars($_SESSION['oauth_info']['image'])?>" /><?php } ?>
            You are logged in as
            <?php if ($_SESSION['oauth_info']['url']) { ?>
                <a href="<?= htmlspecialchars($_SESSION['oauth_info']['url']) ?>"><?= htmlspecialchars($_SESSION['oauth_info']['name']) ?></a>
            <?php } else { ?>
                <?= htmlspecialchars($_SESSION['oauth_info']['name']) ?>
            <?php } ?>
            &lt;<?= htmlspecialchars($_SESSION['oauth_info']['mail']) ?>&gt; (via <?= htmlspecialchars($_SESSION['oauth_info']['provider']) ?>).
            <a href="<?= htmlspecialchars(BASE_URL) ?>logout.php">Log out</a>
        <?php } else { ?>
            You are not logged in.
            <div class="btn-group">
                <a href="<?= htmlspecialchars(BASE_URL) ?>oauth_login.php?redirect_after_login=<?= urlencode(PAGE_URL) ?>"
                   class="btn btn-default">Log in</a>
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                    <?php

                    foreach ($oauthLogin->getConfiguredServices() as $service) {
                        printf(
                            '<li><a href="%s">%s</a></li>',
                            htmlspecialchars(\Tistre\SimpleOAuthLogin\Login::getUrlWithService(BASE_URL . 'oauth_login.php',
                                $service, PAGE_URL)),
                            htmlspecialchars($oauthLogin->getService($service)->getLoginLinkText())
                        );
                    }

                    ?>
                </ul>
            </div>
        <?php } ?>
    </small>
</p>
