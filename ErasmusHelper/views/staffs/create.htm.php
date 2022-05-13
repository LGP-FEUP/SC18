<?php
 /** @var Faculty[] $faculties */

use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\Faculty;

?>
<div class="row">
    <div class="box col-12 col-md-6">
        <div class="box-header">
            <span class="box-title">Staff member registration</span>
        </div>
        <form method="POST" action="<?= Router::route('staff.create') ?>">
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
                    <div class="label">Faculty</div>
                    <select name="faculty_id" class="value">
                        <option disabled>Select a faculty</option>
                        <?php foreach ($faculties as $faculty): ?>
                            <option value="<?= $faculty->id; ?>"><?= $faculty->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="field">
                    <div class="label">Privilege level</div>
                    <select name="privilege_level" class="value">
                        <option disabled>Select a level</option>
                        <option value="1" disabled>Global Administrator</option>
                        <option value="2">University Moderator</option>
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
</div>