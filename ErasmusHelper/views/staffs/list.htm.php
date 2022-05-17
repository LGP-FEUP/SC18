<?php
/**
 * @var UniModerator[] $uniMods
 * @var CityModerator[] $cityMods
 * @var CountryModerator[] $countryMods
 */

use ErasmusHelper\App;
use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\CityModerator;
use ErasmusHelper\Models\CountryModerator;
use ErasmusHelper\Models\UniModerator;

?>
<div class="row">
    <div class="box no-padding col-12">
        <div class="box-content">
            <div class="table-wrapper">
                <table class="table <?= empty($countryMods) ? 'empty' : '' ?>">
                    <tr>
                        <th>Identifier</th>
                        <th>Email Address</th>
                        <th>Level</th>
                        <th><a class="button" href="<?= Router::route('staff.create.page') ?>" ><i class="fas fa-plus r"></i>Add a staff member</a></th>
                    </tr>
                    <?php
                    if(App::getInstance()->auth->getPrivilegeLevel() == ADMIN_PRIVILEGES) {
                        if(!empty($countryMods)) {
                            foreach ($countryMods as $countryMod): ?>
                                <tr bgcolor="<?= $countryMod->disabled ? "lightgrey" : "white"; ?>">
                                    <td><?= $countryMod->id; ?></td>
                                    <td><?= $countryMod->email; ?></td>
                                    <td><?= App::getPrivilegeName($countryMod::PRIVILEGE_LEVEL); ?></td>
                                    <td><a class="button" href="<?= Router::route('staff', ["id" => $countryMod->id]) ?>"><i class="far fa-eye r"></i>Details</a></td>
                                </tr>
                            <?php endforeach;
                        }
                    }
                    if(App::getInstance()->auth->getPrivilegeLevel() <= COUNTRYMODERATORS_PRIVILEGES) {
                        if(!empty($cityMods)) {
                            foreach ($cityMods as $cityMod): ?>
                                <tr bgcolor="<?= $cityMod->disabled ? "lightgrey" : "white"; ?>">
                                    <td><?= $cityMod->id; ?></td>
                                    <td><?= $cityMod->email; ?></td>
                                    <td><?= App::getPrivilegeName($cityMod::PRIVILEGE_LEVEL); ?></td>
                                    <td><a class="button" href="<?= Router::route('staff', ["id" => $cityMod->id]) ?>"><i class="far fa-eye r"></i>Details</a></td>
                                </tr>
                            <?php endforeach;
                        }
                    }
                    if(App::getInstance()->auth->getPrivilegeLevel() <= CITYMODERATORS_PRIVILEGES) {
                        if(!empty($uniMods)) {
                            foreach ($uniMods as $uniMod): ?>
                                <tr bgcolor="<?= $uniMod->disabled ? "lightgrey" : "white"; ?>">
                                    <td><?= $uniMod->id; ?></td>
                                    <td><?= $uniMod->email; ?></td>
                                    <td><?= App::getPrivilegeName($uniMod::PRIVILEGE_LEVEL); ?></td>
                                    <td><a class="button" href="<?= Router::route('staff', ["id" => $uniMod->id]) ?>"><i class="far fa-eye r"></i>Details</a></td>
                                </tr>
                            <?php endforeach;
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>