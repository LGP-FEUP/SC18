<?php
/** @var $content */

use ErasmusHelper\App;
use ErasmusHelper\Controllers\Router;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home - ErasmusHelper</title>
    <link rel="icon" href="<?= Router::resource("images", "favicon.svg") ?>" sizes="any" type="image/svg+xml">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <script src="https://kit.fontawesome.com/269a112bad.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= Router::resource("style/css", "main.css") ?>"/>
    <link rel="stylesheet" href="<?= Router::resource("style/css", "app.css") ?>"/>
</head>
<body id="master">
<header>
    <nav>
        <div class="header-menu">
            <a id="main-logo" href="<?= Router::route("/") ?>"><img src="<?= Router::resource("images", "logo.png") ?>"></a>
        </div>
        <div class="header-menu">
            <?php
            if (App::getInstance()->auth->isAuth()) {
                ?>
                <a class="link" href="<?= Router::route("menu") ?>"><i class="fas fa-user r"></i>BackOffice</a>
                <?php
            } else {
                ?>
                <a class="link" href="<?= Router::route("login") ?>"><i class="fas fa-user r"></i>Log in</a>
                <?php
            }
            ?>
        </div>
    </nav>
</header>
<div id="app">
    <?= $content; ?>
</div>
<div id="notification-container"></div>
<script src="<?= Router::resource("scripts", "common.js") ?>"></script>
<script src="<?= Router::resource("scripts/classes", "Modal.js") ?>"></script>
<script src="<?= Router::resource("scripts/classes", "Ui.js") ?>"></script>
<?php if (isset($alert)): ?>
    <script type="text/javascript">
        Ui.notify("<?= addslashes($alert[array_key_first($alert)]) ?>", "<?= array_key_first($alert) ?>");
    </script>
<?php endif; ?>
</body>
</html>
