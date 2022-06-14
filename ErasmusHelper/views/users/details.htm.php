<?php
/**
 * @var int $id
 *  @var Faculty[] $faculties
 */


use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\Country;
use ErasmusHelper\Models\Faculty;
use ErasmusHelper\Models\User;

?>
<div class="row">
    <div class="col-12 col-xl-6">
        <div class="row">
            <div class="box col-12 wr">
                <div class="box-header">
                    <span class="box-title"><?php
                        $user = User::select(["id" => $id]);
                        echo $user->firstname . " " . $user->lastname;
                        ?></span>
                </div>
                <form method="POST" action="<?= Router::route('user.edit', ["id" => $user->id]) ?>">
                    <div class="box-content">
                        <div class="field">
                            <div class="label">Identifier</div>
                            <input name="id" class="value" type="text" value="<?= $user->id; ?>"disabled/>
                        </div>
                        <div class="field">
                            <div class="label">Faculty of arrival</div>
                            <select name="faculty_id" class="value">
                                <option disabled>Select a faculty</option>
                                <?php foreach ($faculties as $faculty): ?>
                                    <option <?php if($faculty->id == $user->faculty_arriving_id){echo "selected";} ?> value="<?= $faculty->id; ?>"><?= $faculty->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="field">
                            <div class="label">Validation level</div>
                            <select name="validation_level" class="value">
                                <option disabled>Select a level</option>
                                <option <?php if($user->validation_level == 1){echo "selected";} ?> value="1">Student unknown</option>
                                <option <?php if($user->validation_level == 2){echo "selected";} ?> value="2">Student this semester</option>
                                <option <?php if($user->validation_level == 3){echo "selected";} ?> value="3">Student from previous semester(s)</option>
                            </select>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="button-group">
                            <a href="<?= Router::route('users') ?>" class="button">Cancel</a>
                            <?php $ability = $user->isDisabled() ?>
                            <a onclick="confirm('Confirm the user ability update request ?') ? window.location = '<?= Router::route('user.ability', ["id" => $user->id]) ?>' : void(0)" class="button <?= $ability ? "green" : "red" ?>"><?= $ability ? "Enable" : "Disable" ?></a>
                            <button type="submit" class="button cta">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

