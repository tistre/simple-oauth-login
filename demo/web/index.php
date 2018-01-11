<?php require dirname(__DIR__) . '/init.php'; ?>
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

    <h1>Simple OAuth2 login demo</h1>

    <p>This page is public, no login required.</p>

    <p>Try accessing <a href="protected.php">a protected page</a>.</p>

    <?php include __DIR__ . '/footer.php'; ?>

</div>

<script src="jquery/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>