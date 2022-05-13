<?php
/** @var Department $department */

use ErasmusHelper\Models\Department;
?>

<div class="menu">
    <div class="menu-title">
        <?= $department->name ?>
        <div class="button-input">
            <form method="POST" action="<?= route("configuration.cities.create", [$department->id]) ?>">
                <input class="input" type="text" name="name" placeholder="Tours"/>
                <input class="button" type="submit" value="+"/>
            </form>
        </div>
    </div>
    <div class="menu-content">
        <?php foreach ($department->getCities() as $city): ?>
            <?php include "city.htm.php"; ?>
        <?php endforeach; ?>
    </div>
</div>
