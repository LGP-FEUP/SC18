<?php
/** @var $content */

use ErasmusHelper\Controllers\Router;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - ErasmusHelper</title>
    <link rel="icon" type="image/png" href="<?= Router::resource("images", "title.png"); ?>">
    <link rel="stylesheet" href="<?= Router::resource("style/css", "main.css")?>" />
</head>
<body>
    <div id="login_bg">
        <div id="titleImg"></div>
        <?= $content; ?>
    </div>
    <div id="notification-container"></div>
    <script src="<?= Router::resource("scripts", "common.js") ?>"></script>
    <script src="<?= Router::resource("scripts/classes", "Ui.js") ?>"></script>
    <?php if(isset($alert)): ?>
        <script type="text/javascript">
            Ui.notify("<?= addslashes($alert[array_key_first($alert)]) ?>", "<?= array_key_first($alert) ?>");
        </script>
    <?php endif; ?>
</body>
</html>
