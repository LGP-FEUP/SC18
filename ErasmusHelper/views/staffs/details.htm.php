<?php
/** @var int $id
 *  @var Faculty[] $faculties
 */


use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\Faculty;
use ErasmusHelper\Models\UniModerator;
use ErasmusHelper\Models\User;

?>
<div class="row">
    <div class="col-12 col-xl-6">
        <div class="row">
            <div class="box col-12 wr">
                <div class="box-header">
                    <span class="box-title"><?php
                        $staff = UniModerator::getById($id);
                        echo $staff->id;
                        ?></span>
                </div>
                <form method="POST" action="<?= Router::route('staff.edit', ["id" => $staff->id]) ?>">
                    <div class="box-content">
                        <div class="field">
                            <div class="label">Identifier</div>
                            <input name="id" class="value" type="text" value="<?= $staff->id; ?>"disabled/>
                        </div>
                        <div class="field">
                            <div class="label">Email Address</div>
                            <input name="email" class="value" type="text" value="<?= $staff->email; ?>"/>
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
                            <button type="submit" class="button cta">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

