<?php
/** @var City[] $cities */

use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\City;

?>

<div class="row">
    <div class="box no-padding col-12">
        <div class="box-content">
            <div class="table-wrapper">
                <table class="table <?= empty($cities) ? 'empty' : '' ?>">
                    <tr>
                        <th>Identifier</th>
                        <th>Name</th>
                        <th>Country</th>
                        <th><a class="button" href="<?= Router::route('city.create.page') ?>" ><i class="fas fa-plus r"></i>Add a city</a></th>
                    </tr>
                    <?php foreach ($cities as $city): ?>
                        <tr>
                            <td><?= $city->id; ?></td>
                            <td><?= $city->name; ?></td>
                            <td><?= $city->getCountry()->name?></td>
                            <td><a class="button" href="<?= Router::route('city', ["id" => $city->id]) ?>"><i class="far fa-eye r"></i>Details</a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>
