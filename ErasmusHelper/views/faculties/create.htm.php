<?php
/**
 * @var City[] $cities
 * @var City $city
 */

use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\City;

?>
<div class="row">
    <div class="box col-12 col-md-6">
        <div class="box-header">
            <span class="box-title">Faculty registration</span>
        </div>
        <form method="POST" action="<?= Router::route('faculty.create') ?>">
            <div class="box-content">
                <div class="field">
                    <div class="label">Name of the faculty</div>
                    <input name="name" class="value" type="text" value=""/>
                </div>
                <div class="field">
                    <div class="label">Code of the faculty</div>
                    <input name="code" class="value" type="text" value=""/>
                </div>
                <div class="field">
                    <div class="label">City</div>
                    <select name="city_id" class="value">
                        <option selected disabled>Select a city</option>
                        <?php if(!empty($cities)) {
                            foreach ($cities as $city): ?>
                                <option value="<?= $city->id; ?>"><?= $city->name; ?></option>
                            <?php endforeach;
                        } else { ?>
                            <option value="<?= $city->id; ?>"><?= $city->name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="box-footer">
                <div class="button-group">
                    <a href="<?= Router::route('faculties') ?>" class="button">Cancel</a>
                    <button type="submit" class="button cta">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>




