<?php
/**
 * @var Country[] $countries
 * @var Country $country
 */

use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\Country;

?>
<div class="row">
    <div class="box col-12 col-md-6">
        <div class="box-header">
            <span class="box-title">City registration</span>
        </div>
        <form method="POST" action="<?= Router::route('city.create') ?>">
            <div class="box-content">
                <div class="field">
                    <div class="label">Name</div>
                    <input name="name" class="value" type="text" value=""/>
                </div>
                <div class="field">
                    <div class="label">Country</div>
                    <select name="country_id" class="value">
                        <option selected disabled>Select a country</option>
                        <?php if(!empty($countries)) {
                            foreach ($countries as $country): ?>
                            <option value="<?= $country->id; ?>"><?= $country->name; ?></option>
                            <?php endforeach;
                        } else { ?>
                            <option value="<?= $country->id; ?>"><?= $country->name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="box-footer">
                <div class="button-group">
                    <a href="<?= Router::route('cities') ?>" class="button">Cancel</a>
                    <button type="submit" class="button cta">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>