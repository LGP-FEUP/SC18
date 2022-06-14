<?php
/**
 * @var int $id
 * @var Faculty[] $faculties
 * @var City[] $cities
 * @var Country[] $countries
 */


use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\City;
use ErasmusHelper\Models\CityModerator;
use ErasmusHelper\Models\Country;
use ErasmusHelper\Models\CountryModerator;
use ErasmusHelper\Models\Faculty;
use ErasmusHelper\Models\UniModerator;
use ErasmusHelper\Models\User;

?>
<div class="row">
    <div class="col-12 col-xl-6">
        <div class="row">
            <div class="box col-12 wr">
                <div class="box-header">
                    <span class="box-title">
                        <?php
                        $uniMod = UniModerator::getById($id);
                        $cityMod = CityModerator::getById($id);
                        $countryMod = CountryModerator::getById($id);

                        if($uniMod != null) {
                            $staff = $uniMod;
                            $type = UniModerator::PRIVILEGE_LEVEL;
                        } elseif($cityMod != null) {
                            $staff = $cityMod;
                            $type = CityModerator::PRIVILEGE_LEVEL;
                        } elseif ($countryMod != null) {
                            $staff = $countryMod;
                            $type = CountryModerator::PRIVILEGE_LEVEL;
                        } else {
                            Router::route('staffs');
                        }
                        echo $staff->id;
                        ?>
                    </span>
                </div>
                <?php if ($type == UniModerator::PRIVILEGE_LEVEL) { ?>
                    <form method="POST" action="<?= Router::route('staff.edit.uni', ["id" => $staff->id]) ?>">
                        <div class="box-content">
                            <div class="field">
                                <div class="label">Identifier</div>
                                <input name="id" class="value" type="text" value="<?= $staff->id; ?>"disabled/>
                            </div>
                            <div class="field">
                                <div class="label">Email Address</div>
                                <input id="email" name="email" class="value" type="text" value="<?= $staff->email; ?>"/>
                            </div>
                            <div class="field">
                                <div class="label">Faculty</div>
                                <select name="faculty_id" class="value">
                                    <option disabled>Select a faculty</option>
                                    <?php foreach ($faculties as $faculty): ?>
                                        <option <?php if($faculty->id == $staff->faculty_id){echo "selected";} ?> value="<?= $faculty->id; ?>"><?= $faculty->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="button-group">
                                <a href="<?= Router::route('staffs') ?>" class="button">Cancel</a>
                                <a onclick="confirm('Confirm the staff member ability update request ?') ? window.location = '<?= Router::route('staff.ability', ["id" => $staff->id]) ?>' : void(0)" class="button <?= $staff->disabled ? "green" : "red" ?>"><?= $staff->disabled ? "Enable" : "Disable" ?></a>
                                <button id="submit" type="submit" class="button cta">Submit</button>
                                <div id="status" class="label" hidden></div>
                            </div>
                        </div>
                    </form>
                <?php
                } elseif ($type == CityModerator::PRIVILEGE_LEVEL) { ?>
                    <form method="POST" action="<?= Router::route('staff.edit.city', ["id" => $staff->id]) ?>">
                        <div class="box-content">
                            <div class="field">
                                <div class="label">Identifier</div>
                                <input name="id" class="value" type="text" value="<?= $staff->id; ?>"disabled/>
                            </div>
                            <div class="field">
                                <div class="label">Email Address</div>
                                <input id="email" name="email" class="value" type="text" value="<?= $staff->email; ?>"/>
                            </div>
                            <div class="field">
                                <div class="label">City</div>
                                <select name="city_id" class="value">
                                    <option disabled>Select a city</option>
                                    <?php foreach ($cities as $city): ?>
                                        <option <?php if($city->id == $staff->city_id){echo "selected";} ?> value="<?= $city->id; ?>"><?= $city->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="button-group">
                                <a href="<?= Router::route('staffs') ?>" class="button">Cancel</a>
                                <a onclick="confirm('Confirm the staff member ability update request ?') ? window.location = '<?= Router::route('staff.ability', ["id" => $staff->id]) ?>' : void(0)" class="button <?= $staff->disabled ? "green" : "red" ?>"><?= $staff->disabled ? "Enable" : "Disable" ?></a>
                                <button id="submit" type="submit" class="button cta">Submit</button>
                                <div id="status" class="label" hidden></div>
                            </div>
                        </div>
                    </form>
                <?php } elseif ($type == CountryModerator::PRIVILEGE_LEVEL) { ?>
                    <form method="POST" action="<?= Router::route('staff.edit.country', ["id" => $staff->id]) ?>">
                        <div class="box-content">
                            <div class="field">
                                <div class="label">Identifier</div>
                                <input name="id" class="value" type="text" value="<?= $staff->id; ?>"disabled/>
                            </div>
                            <div class="field">
                                <div class="label">Email Address</div>
                                <input id="email" name="email" class="value" type="text" value="<?= $staff->email; ?>"/>
                            </div>
                            <div class="field">
                                <div class="label">Country</div>
                                <select name="country_id" class="value">
                                    <option disabled>Select a country</option>
                                    <?php foreach ($countries as $country): ?>
                                        <option <?php if($country->id == $staff->country_id){echo "selected";} ?> value="<?= $country->id; ?>"><?= $country->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="button-group">
                                <a href="<?= Router::route('staffs') ?>" class="button">Cancel</a>
                                <a onclick="confirm('Confirm the staff member ability update request ?') ? window.location = '<?= Router::route('staff.ability', ["id" => $staff->id]) ?>' : void(0)" class="button <?= $staff->disabled ? "green" : "red" ?>"><?= $staff->disabled ? "Enable" : "Disable" ?></a>
                                <button id="submit" type="submit" class="button cta">Submit</button>
                                <div id="status" class="label" hidden></div>
                            </div>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    let emailField = document.getElementById("email");
    let submit = document.getElementById("submit");
    let status = document.getElementById("status");

    function checkEmailValidity(){
        return !!emailField.value
            .toLowerCase()
            .match(
                /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            );
    }

    function updateSubmit() {

        if(checkEmailValidity()) {
            status.setAttribute("hidden", "hidden");
            submit.removeAttribute("disabled");
        } else {
            status.innerHTML = "Email invalid.";
            status.removeAttribute("hidden");
            submit.setAttribute("disabled", "disabled");
        }
    }

    emailField.addEventListener("input", () => {
        updateSubmit();
    });
</script>

