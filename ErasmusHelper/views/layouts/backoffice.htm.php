<?php
/**
 * @var $content
 * @var $title
 */

use ErasmusHelper\App;
use ErasmusHelper\Controllers\Router;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php if (isset($title)) {
            echo $title . " - ErasmusHelper";
        } else {
            echo "BackOffice - ErasmusHelper";
        } ?></title>
    <link rel="icon" href="<?= Router::resource("images", "favicon.svg") ?>" sizes="any" type="image/svg+xml">
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
                    href="<?= Router::route("menu") ?>"><i class="fas fa-cogs r"></i>Menu</a>
            <?php if (App::getInstance()->auth->getPrivilegeLevel() <= COUNTRYMODERATORS_PRIVILEGES) { ?>
                <a <?= strpos($_SERVER["REQUEST_URI"], "countries") ? "class='active'" : "" ?>
                        href="<?= Router::route("countries") ?>"><i class="fas fa-globe r"></i>Countries</a>
                <?php
            }
            if (App::getInstance()->auth->getPrivilegeLevel() <= CITYMODERATORS_PRIVILEGES) {
                ?>
                <a <?= strpos($_SERVER["REQUEST_URI"], "cities") ? "class='active'" : "" ?>
                        href="<?= Router::route("cities") ?>"><i class="fas fa-house-user r"></i>Cities</a>
            <?php } ?>
            <a <?= strpos($_SERVER["REQUEST_URI"], "faculties") ? "class='active'" : "" ?>
                    href="<?= Router::route("faculties") ?>"><i class="fas fa-laptop-house r"></i>Faculties</a>
            <?php
            if (App::getInstance()->auth->getPrivilegeLevel() == UNIMODERATORS_PRIVILEGES) {
                ?>
                <a <?= strpos($_SERVER["REQUEST_URI"], "tasks") ? "class='active'" : "" ?>
                        href="<?= Router::route("tasks") ?>"><i class="fas fa-list r"></i>Tasks</a>
                <a <?= strpos($_SERVER["REQUEST_URI"], "university_faqs") ? "class='active'" : "" ?>
                        href="<?= Router::route("university_faqs") ?>"><i class="fas fa-sticky-note r"></i>FAQ</a>
            <?php } ?>
            <a <?= strpos($_SERVER["REQUEST_URI"], "users") ? "class='active'" : "" ?>
                    href="<?= Router::route("users") ?>"><i class="fas fa-users r"></i>Users</a>
            <?php if (App::getInstance()->auth->getPrivilegeLevel() <= CITYMODERATORS_PRIVILEGES) { ?>
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
                <a class="<?= strpos($_SERVER["REQUEST_URI"], "account") ? "active" : "link" ?>"
                   href="<?= Router::route("account") ?>"><i
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
<script src="<?= Router::resource("scripts/classes", "Modal.js") ?>"></script>
<script src="<?= Router::resource("scripts/classes", "Ui.js") ?>"></script>
<?php if (isset($alert)): ?>
    <script type="text/javascript">
        Ui.notify("<?= addslashes($alert[array_key_first($alert)]) ?>", "<?= array_key_first($alert) ?>");
    </script>
<?php endif; ?>
</body>
</html>
