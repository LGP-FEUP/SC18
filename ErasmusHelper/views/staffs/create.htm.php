<?php
 /**
  * @var Faculty[] $faculties
  * @var City[] $cities
  * @var Country[] $countries
  */

use ErasmusHelper\App;
use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\City;
use ErasmusHelper\Models\Country;
use ErasmusHelper\Models\Faculty;

?>
<div class="row">
    <?php
    if(App::getInstance()->auth->getPrivilegeLevel() <= COUNTRYMODERATORS_PRIVILEGES) { ?>
        <?php
        if(App::getInstance()->auth->getPrivilegeLevel() == ADMIN_PRIVILEGES) { ?>
            <div class="box col-12 col-md-6">
                <div class="box-header">
                    <span class="box-title">Add a Country Moderator</span>
                </div>
                <form method="POST" action="<?= Router::route('staff.create.country') ?>">
                    <div class="box-content">
                        <div class="field">
                            <div class="label">Email</div>
                            <input name="email" class="value" type="text" value=""/>
                        </div>
                        <div class="field">
                            <div class="label">Password</div>
                            <input name="password" class="value" type="password" value=""/>
                        </div>
                        <div class="field">
                            <div class="label">Privilege level</div>
                            <input name="privilege_level" class="value", type="text", value="Country Moderator" disabled>
                        </div>
                        <div class="field">
                            <div class="label">Country</div>
                            <select name="country_id" class="value">
                                <option disabled>Select a country</option>
                                <?php foreach ($countries as $country): ?>
                                    <option value="<?= $country->id; ?>"><?= $country->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="button-group">
                            <a href="<?= Router::route('staffs') ?>" class="button">Cancel</a>
                            <button type="submit" class="button cta">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        <?php
        }
        if(App::getInstance()->auth->getPrivilegeLevel() <= COUNTRYMODERATORS_PRIVILEGES) { ?>
            <div class="box col-12 col-md-6">
                <div class="box-header">
                    <span class="box-title">Add a City Moderator</span>
                </div>
                <form method="POST" action="<?= Router::route('staff.create.city') ?>">
                    <div class="box-content">
                        <div class="field">
                            <div class="label">Email</div>
                            <input name="email" class="value" type="email" value=""/>
                        </div>
                        <div class="field">
                            <div class="label">Password</div>
                            <input name="password" class="value" type="password" value=""/>
                        </div>
                        <div class="field">
                            <div class="label">Privilege level</div>
                            <input name="privilege_level" class="value", type="text", value="City Moderator" disabled>
                        </div>
                        <div class="field">
                            <div class="label">City</div>
                            <select name="city_id" class="value">
                                <option disabled>Select a city</option>
                                <?php foreach ($cities as $city): ?>
                                    <option value="<?= $city->id; ?>"><?= $city->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="button-group">
                            <a href="<?= Router::route('staffs') ?>" class="button">Cancel</a>
                            <button type="submit" class="button cta">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        <?php
        }
    }
    if (App::getInstance()->auth->getPrivilegeLevel() <= CITYMODERATORS_PRIVILEGES) { ?>
    <div class="box col-12 col-md-6">
        <div class="box-header">
            <span class="box-title">Add a Uni Moderator</span>
        </div>
        <form method="POST" action="<?= Router::route('staff.create.uni') ?>">
            <div class="box-content">
                <div class="field">
                    <div class="label">Email</div>
                    <input name="email" class="value" type="text" value=""/>
                </div>
                <div class="field">
                    <div class="label">Password</div>
                    <input name="password" class="value" type="password" value=""/>
                </div>
                <div class="field">
                    <div class="label">Privilege level</div>
                    <input name="privilege_level" class="value", type="text", value="Uni Moderator" disabled>
                </div>
                <div class="field">
                    <div class="label">Faculty</div>
                    <select name="faculty_id" class="value">
                        <option disabled>Select a faculty</option>
                        <?php foreach ($faculties as $faculty): ?>
                            <option value="<?= $faculty->id; ?>"><?= $faculty->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="box-footer">
                <div class="button-group">
                    <a href="<?= Router::route('staffs') ?>" class="button">Cancel</a>
                    <button type="submit" class="button cta">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <?php } ?>
</div>