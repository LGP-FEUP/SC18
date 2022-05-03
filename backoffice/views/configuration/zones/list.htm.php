<?php
/** @var $regions Region[] */

use ErasmusHelper\Models\Region;
?>

<div class="box col-12">
    <div class="box-header">
        <div class="box-title">Régions</div>
        <div class="box-actions">
            <div class="button-input">
                <form method="POST" action="<?= route("configuration.regions.create") ?>">
                    <input class="input" name="name" type="text" placeholder="Centre Val de Loire"/>
                    <input class="button" type="submit" value="+"/>
                </form>
            </div>
        </div>
    </div>
    <div class="box-content">
        <div class="menu-group">
            <?php foreach ($regions as $region): ?>
                <?php include "region.htm.php"; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
