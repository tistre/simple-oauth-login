<?php

require dirname(__DIR__) . '/init.php';

oauth_login_if_not_authenticated();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Simple OAuth2 login demo: Protected page</title>
    <link href="bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" media="screen"/>
</head>
<body>
<div class="container">

    <h1>Protected page</h1>

    <p>Back to <a href="<?= htmlspecialchars(BASE_URL) ?>">the index page</a>.</p>

    <?php include __DIR__ . '/footer.php'; ?>

</div>

<script src="jquery/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
