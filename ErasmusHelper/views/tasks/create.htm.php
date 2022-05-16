<?php

use ErasmusHelper\Controllers\Router;

?>
<div class="row">
    <div class="box col-12 col-md-6">
        <div class="box-header">
            <span class="box-title">task Item registration</span>
        </div>
        <form method="POST" action="<?= Router::route('task.create') ?>">
            <div class="box-content">
                <div class="field">
                    <div class="label">Name</div>
                    <input name="title" class="value" type="text"/>
                </div>
                <div class="field">
                    <div class="label">Before Arrival</div>
                    <input name="when" class="value" type="radio"
                           value="before"/>
                </div>
                <div class="field">
                    <div class="label">During Stay</div>
                    <input name="when" class="value" type="radio"
                           value="during"/>
                </div>
                <div class="field">
                    <div class="label">After Departure</div>
                    <input name="when" class="value" type="radio"
                           value="after"/>
                </div>
                <div class="field">
                    <div class="label">Deadline</div>
                    <input name="due_date" class="value" type="date"/>
                </div>
            </div>
            <div class="box-footer">
                <div class="button-group">
                    <a href="<?= Router::route('tasks') ?>" class="button">Cancel</a>
                    <button type="submit" class="button cta">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>