<?php

use ErasmusHelper\Controllers\ExcelController;
use ErasmusHelper\Controllers\Router; ?>
<div class="row">
    <div class="box col-12">
        <form method="POST" action="<?= Router::route('users.excel.create') ?>" enctype="multipart/form-data">
            <div class="box-content">
                <div class="field">
                    <div class="label">.xls and .xlsx supported: </div>
                    <input type="file" accept=".xls,.xlsx" name="excel" required/>
                </div>
                <div class="field">
                    <div class="label">Body of the mail: </div>
                    <textarea name="body" rows="10" style="width: 1000px;" class="input" type="text"><?= ExcelController::$default_message ?></textarea>
                </div>
                <div class="field">
                    <div class="label">Footer of the mail: </div>
                    <textarea name="body" rows="5" class="input col-8" type="text" disabled><?= ExcelController::$default_footer ?></textarea>
                </div>
            </div>
            <div class="box-footer">
                <div class="button-group">
                    <a href="<?= Router::route('users') ?>" class="button">Cancel</a>
                    <button type="submit" class="button cta">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>