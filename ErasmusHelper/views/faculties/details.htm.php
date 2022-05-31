<?php
/**
 * @var int $id
 * @var City[] $cities
 * @var User[] $students_incoming
 * @var User[] $students_outgoing
 */


use ErasmusHelper\App;
use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\City;
use ErasmusHelper\Models\Faculty;
use ErasmusHelper\Models\User;

?>
<div class="flex-column">
    <?php if(!empty($students_incoming) || !empty($students_outgoing)) { ?>
        <div class="row">
            <?php if(!empty($students_incoming)) { ?>
                <div class="box col-12 col-md-6">
                    <div class="box-header">
                        <span class="box-title">Incoming students</span>
                    </div>
                    <div class="box-content">
                        <div class="table-wrapper">
                            <table class="table">
                                <tr>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Date of birth</th>
                                    <th></th>
                                </tr>
                                <?php foreach ($students_incoming as $student){ ?>
                                    <tr bgcolor="<?= $student->isDisabled() ? "lightgrey" : "white"; ?>">
                                        <td><?= $student->firstname; ?></td>
                                        <td><?= $student->lastname; ?></td>
                                        <td><?= $student->computeBirthDate(); ?></td>
                                        <td><a class="button" href="<?= Router::route('user', ["id" => $student->id]) ?>"><i class="far fa-eye r"></i>Details</a></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            <?php }
            if(!empty($students_outgoing)) { ?>
                <div class="box col-12 col-md-6">
                    <div class="box-header">
                        <span class="box-title">Outgoing students</span>
                    </div>
                    <div class="box-content">
                        <div class="table-wrapper">
                            <table class="table">
                                <tr>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Date of birth</th>
                                    <th></th>
                                </tr>
                                <?php foreach ($students_outgoing as $student){ ?>
                                    <tr bgcolor="<?= $student->isDisabled() ? "lightgrey" : "white"; ?>">
                                        <td><?= $student->firstname; ?></td>
                                        <td><?= $student->lastname; ?></td>
                                        <td><?= $student->computeBirthDate(); ?></td>
                                        <td><a class="button" href="<?= Router::route('user', ["id" => $student->id]) ?>"><i class="far fa-eye r"></i>Details</a></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-12 col-xl-6">
            <div class="row">
                <div class="box col-12 wr">
                    <div class="box-header">
                        <span class="box-title"><?php
                            $faculty = Faculty::select(["id" => $id]);
                            echo $faculty->name;
                            ?></span>
                    </div>
                    <form method="POST" action="<?= Router::route('faculty.edit', ["id" => $faculty->id]) ?>">
                        <div class="box-content">
                            <div class="field">
                                <div class="label">Identifier</div>
                                <input name="id" class="value" type="text" value="<?= $faculty->id; ?>"disabled/>
                            </div>
                            <div class="field">
                                <div class="label">Code</div>
                                <input name="code" class="value" type="text" value="<?= $faculty->code; ?>"disabled/>
                            </div>
                            <div class="field">
                                <div class="label">Name of the faculty</div>
                                <input name="name" class="value" type="text" value="<?= $faculty->name; ?>"/>
                            </div>
                            <div class="field">
                                <div class="label">City</div>
                                <select name="city_id" class="value">
                                    <option disabled>Select a city</option>
                                    <?php foreach ($cities as $city): ?>
                                        <option <?php if($city->id == $faculty->city_id){echo "selected";} ?> value="<?= $city->id; ?>"><?= $city->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="button-group">
                                <a href="<?= Router::route('faculties') ?>" class="button">Cancel</a>
                                <?php if(empty($students_incoming) && empty($students_outgoing) && App::getInstance()->auth->getPrivilegeLevel() == ADMIN_PRIVILEGES) { ?>
                                <a onclick="confirm('Confirm the deletion of the faculty ?') ? window.location = '<?= Router::route('faculty.delete', ["id" => $faculty->id]) ?>' : void(0)" class="button red">Delete</a>
                                <?php } ?>
                                <button type="submit" class="button cta">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

