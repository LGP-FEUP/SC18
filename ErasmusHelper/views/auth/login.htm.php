<?php

use ErasmusHelper\Controllers\Router;

?>
<div id="login">
    <div id="head">
        <h2 id="signin">Connection</h2>
    </div>
    <div id="content">
        <form method="post" action="<?= Router::route("auth") ?>">
            <input type="email" name="mail" placeholder="adminAddress@eh.com" />
            <input type="password" name="password" placeholder="password" />
            <div id="buttons">
                <a href="<?= Router::route('/') ?>" class="button">Cancel</a>
                <input class="button cta" type="submit" id="submit" value="Confirm" />
            </div>
        </form>
    </div>
</div>
