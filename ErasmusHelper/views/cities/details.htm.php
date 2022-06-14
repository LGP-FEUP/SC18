<?php
/** @var int $id
 * @var Country[] $countries
 * @var ?Faculty[] $faculties
 */

use ErasmusHelper\App;
use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\City;
use ErasmusHelper\Models\Country;
use ErasmusHelper\Models\Faculty;

?>
<div class="row">
    <div class="box col-12 col-md-6">
        <div class="box-header">
            <span class="box-title"><?php
                    $city = City::select(["id" => $id]);
                    echo $city->name;
                ?></span>
        </div>
        <form method="POST" action="<?= Router::route('city.edit', ["id" => $city->id]) ?>">
            <div class="box-content">
                <div class="field">
                    <div class="label">Identifier</div>
                    <input name="id" class="value" type="text" value="<?= $city->id; ?>" disabled/>
                </div>
                <div class="field">
                    <div class="label">Name</div>
                    <input name="name" class="value" type="text" value="<?= $city->name; ?>"/>
                </div>
                <div class="field">
                    <div class="label">Country</div>
                    <select name="country_id" class="value">
                        <option disabled>Select a country</option>
                        <?php foreach ($countries as $country): ?>
                        <option <?php if($country->id == $city->country_id){echo "selected";} ?> value="<?= $country->id; ?>"><?= $country->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="box-footer">
                <div class="button-group">
                    <a href="<?= Router::route('cities') ?>" class="button">Cancel</a>
                    <?php if(empty($faculties) && App::getInstance()->auth->getPrivilegeLevel() <= COUNTRYMODERATORS_PRIVILEGES) { ?>
                    <a onclick="confirm('Confirm the deletion of the city ?') ? window.location = '<?= Router::route('city.delete', ["id" => $city->id]) ?>' : void(0)" class="button red">Delete</a>
                    <?php } ?>
                    <button type="submit" class="button cta">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <?php if(!empty($faculties)) { ?>
    <div class="box col-12 col-md-6">
        <div class="box-header">
            <span class="box-title">Associated faculties</span>
        </div>
        <div class="box-content">
            <div class="table-wrapper">
                <table class="table">
                    <tr>
                        <th>Identifier</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th></th>
                    </tr>
                    <?php foreach ($faculties as $faculty){ ?>
                        <tr>
                            <td><?= $faculty->id; ?></td>
                            <td><?= $faculty->code; ?></td>
                            <td><?= $faculty->name; ?></td>
                            <td><a class="button" href="<?= Router::route('faculty', ["id" => $faculty->id]) ?>"><i class="far fa-eye r"></i>Details</a></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
    <?php } ?>
</div>