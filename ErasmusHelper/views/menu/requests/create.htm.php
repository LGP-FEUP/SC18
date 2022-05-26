<?php

use ErasmusHelper\Controllers\Router;
?>
<div class="box col-12">
    <div class="box-header">
        <h1 style="text-align: center" class="box-title">Create a request to the admins:</h1>
    </div>
    <form method="POST" action="<?= Router::route("menu.request.create") ?>">
    <div class="box-content">
        <div class="field">
            <div class="label">Title</div>
            <input maxlength="64" name="title" class="value" type="text" value=""/>
        </div>
        <div class="field">
            <div class="label">Content</div>
            <textarea maxlength="512" name="content" class="value" type="text"></textarea>
        </div>
        <div class="box-footer">
            <div class="button-group">
                <button type="submit" class="button cta">Submit</button>
            </div>
        </div>
    </div>
</div>