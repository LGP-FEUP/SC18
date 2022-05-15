<?php

#/** @var Country[] $countries */

use ErasmusHelper\Controllers\Router;

?>
<div class="row">
    <div class="box col-12 col-md-6">
        <div class="box-header">
            <span class="box-title">Insert New Item to University Tooltips</span>
        </div>
        <form method="POST" action="<?= Router::route('university_faq.create') ?>">
            <div class="box-content">
                <div class="field">
                    <div class="label">Question</div>
                    <input name="question" class="value" type="text" value=""/>
                </div>
            </div>
            <div class="box-content">
                <div class="field">
                    <div class="label">Reply</div>
                    <textarea name="reply" class="value" rows="5"></textarea>
                </div>
            </div>
            <div class="box-footer">
                <div class="button-group">
                    <a href="<?= Router::route('university_faq') ?>" class="button">Cancel</a>
                    <button type="submit" class="button cta">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

