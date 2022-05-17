<?php
/** @var int $id
 *  @var City[] $cities
 */

use ErasmusHelper\App;
use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\City;
use ErasmusHelper\Models\Country;

?>
<div class="row">
    <div class="box col-12 col-md-6">
        <div class="box-header">
            <span class="box-title"><?php
                    $country = Country::select(["id" => $id]);
                    echo $country->name;
                ?></span>
        </div>
        <form method="POST" action="<?= Router::route('country.edit', ["id" => $country->id]) ?>">
            <div class="box-content">
                <div class="field">
                    <div class="label">Identifier</div>
                    <input name="id" class="value" type="text" value="<?= $country->id; ?>" disabled/>
                </div>
                <div class="field">
                    <div class="label">Name</div>
                    <input name="name" class="value" type="text" value="<?= $country->name; ?>"/>
                </div>
            </div>
            <div class="box-footer">
                <div class="button-group">
                    <a href="<?= Router::route('countries') ?>" class="button">Cancel</a>
                    <?php if(empty($cities) && App::getInstance()->auth->getPrivilegeLevel() == ADMIN_PRIVILEGES) { ?>
                    <a onclick="confirm('Confirm the deletion of the country ?') ? window.location = '<?= Router::route('country.delete', ["id" => $country->id]) ?>' : void(0)" class="button red">Delete</a>
                    <?php } ?>
                    <button type="submit" class="button cta">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <?php if(!empty($cities)) { ?>
    <div class="box col-12 col-md-6">
        <div class="box-header">
            <span class="box-title">Associated cities</span>
        </div>
        <div class="box-content">
            <div class="table-wrapper">
                <table class="table">
                    <tr>
                        <th>Identifier</th>
                        <th>Name</th>
                        <th></th>
                    </tr>
                    <?php foreach ($cities as $city){ ?>
                        <tr>
                            <td><?= $city->id; ?></td>
                            <td><?= $city->name; ?></td>
                            <td><a class="button" href="<?= Router::route('city', ["id" => $city->id]) ?>"><i class="far fa-eye r"></i>Details</a></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
    <?php } ?>
</div>