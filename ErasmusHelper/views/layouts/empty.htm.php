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
        <div id="app">
            <?= $content; ?>
        </div>
        <script src="<?= Router::resource("scripts", "common.js") ?>"></script>
        <script src="<?= Router::resource("scripts/classes", "Modal.js") ?>"></script>
        <script src="<?= Router::resource("scripts/classes", "Ui.js") ?>"></script>
    </body>
</html>
