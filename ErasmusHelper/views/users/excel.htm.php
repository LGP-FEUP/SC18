<?php

use ErasmusHelper\Controllers\Router; ?>
<div class="row">
    <div class="box col-12">
        <form method="POST" action="<?= Router::route('users.excel.create') ?>" enctype="multipart/form-data">
            <div class="box-content">
                <div class="field">
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                    <input type="file" accept=".xls,.xlsx" name="excel" />
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