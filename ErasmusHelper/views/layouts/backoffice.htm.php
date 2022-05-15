<?php
/** @var $content */

use ErasmusHelper\App;
use ErasmusHelper\Controllers\Router;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>ErasmusHelper</title>
    <link rel="stylesheet" href="<?= APPLICATION_PATH ?> /public/res/stylesheets/css/main.css"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <script src="https://kit.fontawesome.com/269a112bad.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= Router::resource("style/css", "main.css") ?>"/>
</head>
<body id="master">
<header>
    <nav>
        <div class="header-menu">
            <a id="main-logo" href="<?= Router::route("/") ?>"><img src="<?= Router::resource("images", "logo.png") ?>"></a>
            <a <?= strpos($_SERVER["REQUEST_URI"], "menu") ? "class='active'" : "" ?>
                    href="<?= Router::route("configuration") ?>"><i class="fas fa-cogs r"></i>Main Configuration</a>
            <?php if(App::getInstance()->auth->getPrivilegeLevel() == ADMIN_PRIVILEGES) { ?>
            <a <?= strpos($_SERVER["REQUEST_URI"], "countries") ? "class='active'" : "" ?>
                    href="<?= Router::route("countries") ?>"><i class="fas fa-globe r"></i>Countries</a>
            <a <?= strpos($_SERVER["REQUEST_URI"], "cities") ? "class='active'" : "" ?>
                    href="<?= Router::route("cities") ?>"><i class="fas fa-house-user r"></i>Cities</a>
            <?php } ?>
            <a <?= strpos($_SERVER["REQUEST_URI"], "faculties") ? "class='active'" : "" ?>
                    href="<?= Router::route("faculties") ?>"><i class="fas fa-laptop-house r"></i>Faculties</a>
            <a <?= strpos($_SERVER["REQUEST_URI"], "users") ? "class='active'" : "" ?>
                    href="<?= Router::route("users") ?>"><i class="fas fa-list-ul r"></i>Users</a>
            <?php if(App::getInstance()->auth->getPrivilegeLevel() == ADMIN_PRIVILEGES) { ?>
            <a <?= strpos($_SERVER["REQUEST_URI"], "staffs") ? "class='active'" : "" ?>
                    href="<?= Router::route("staffs") ?>"><i class="fas fa-address-book r"></i>Staff Management</a>
            <?php } ?>
        </div>
        <div class="header-menu">
            <?php
            if (!App::getInstance()->auth->isAuth()) {
                ?>
                <a class="link" href="<?= Router::route("login") ?>"><i class="fas fa-user r"></i>Log in
                    (Administrators)</a>
                <?php
            } else {
                ?>
                <a class="link" href="<?= Router::route("login") ?>"><i
                            class="fas fa-user r"></i><?php echo App::getInstance()->firebase->auth->getUser(App::getInstance()->auth->getAdminUID())->email; ?>
                </a>
                <a class="link" type="button" href="<?= Router::route("logout") ?>">Log out</a>
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
<script src="<?= Router::resource("scripts/classes", "Ui.js") ?>"></script>
<?php if (isset($alert)): ?>
    <script type="text/javascript">
        Ui.notify("<?= addslashes($alert[array_key_first($alert)]) ?>", "<?= array_key_first($alert) ?>");
    </script>
<?php endif; ?>
</body>
</html>
