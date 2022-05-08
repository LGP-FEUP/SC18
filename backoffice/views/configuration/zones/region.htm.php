<?php
/** @var Region $region */

use ErasmusHelper\Models\Region;
?>

<div class="menu">
    <div class="menu-title">
        <?= $region->name; ?>
        <div class="button-input">
            <form method="POST" action="<?= route("configuration.departments.create", [$region->id]) ?>">
                <input class="input" name="name" type="text" placeholder="Indre et Loire"/>
                <input class="button" type="submit" value="+"/>
            </form>
        </div>
    </div>
    <div class="menu-content">
        <?php foreach ($region->getDepartments() as $department): ?>
            <?php include "department.htm.php"; ?>
        <?php endforeach; ?>
    </div>
</div>

