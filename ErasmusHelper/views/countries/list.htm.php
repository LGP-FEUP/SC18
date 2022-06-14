<?php
/**
 * @var Country[] $countries
 * @var Country $country
 */

use ErasmusHelper\App;
use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\Country;

?>

<div class="row">
    <div class="box no-padding col-12">
        <div class="box-content">
            <div class="table-wrapper">
                <table class="table <?= empty($countries) ? 'empty' : '' ?>">
                    <tr>
                        <th>Identifier</th>
                        <th>Name</th>
                        <th><?php if(App::getInstance()->auth->getPrivilegeLevel() == ADMIN_PRIVILEGES) { ?><a class="button" href="<?= Router::route('country.create.page') ?>" ><i class="fas fa-plus r"></i>Add a country</a><?php } ?></th>
                    </tr>
                    <?php
                    if(!empty($countries)) {
                        foreach ($countries as $country): ?>
                            <tr>
                                <td><?= $country->id; ?></td>
                                <td><?= $country->name; ?></td>
                                <td><a class="button" href="<?= Router::route('country', ["id" => $country->id]) ?>"><i class="far fa-eye r"></i>Details</a></td>
                            </tr>
                        <?php endforeach;
                    } else { ?>
                        <tr>
                            <td><?= $country->id; ?></td>
                            <td><?= $country->name; ?></td>
                            <td><a class="button" href="<?= Router::route('country', ["id" => $country->id]) ?>"><i class="far fa-eye r"></i>Details</a></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>
