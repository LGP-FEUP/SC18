<?php
/** @var Country[] $countries */

use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\Country;

?>
<div class="row">
    <div class="box col-12 col-md-6">
        <div class="box-header">
            <span class="box-title">Country registration</span>
        </div>
        <form method="POST" action="<?= Router::route('country.create') ?>">
            <div class="box-content">
                <div class="field">
                    <div class="label">Name</div>
                    <input name="name" class="value" type="text" value=""/>
                </div>
            </div>
            <div class="box-footer">
                <div class="button-group">
                    <a href="<?= Router::route('countries') ?>" class="button">Cancel</a>
                    <button type="submit" class="button cta">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>