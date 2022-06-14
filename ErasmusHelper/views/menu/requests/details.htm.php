<?php
/**
 * @var BackOfficeRequest $request
 */

use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\BackOfficeRequest;

?>
<div class="box col-12">
    <div class="box-header">
        <h1 style="text-align: center" class="box-title"><?= $request->title?></h1>
    </div>
    <div class="box-content">
        <div class="field">
            <label class="label m-1" for="searchBar">Request Content: </label>
            <label style="text-align: center" type="text" class="value"><?= $request->content ?></label>
        </div>
        <div class="field">
            <label class="label m-1" for="searchBar">Request Author: </label>
            <label style="text-align: center" type="text" class="value"><?= $request->author ?></label>
        </div>
        <div class="box-footer">
            <div class="button-group">
                <a class="button red" href="<?= Router::route("menu.request.reject", ["id" => $request->id])?>">Reject</a>
                <a class="button green" href="<?= Router::route("menu.request.validate", ["id" => $request->id])?>">Validate</a>
            </div>
        </div>
    </div>
</div>