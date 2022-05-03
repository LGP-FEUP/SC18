<?php
/** @var Country[] $countries
 *  @var Faculty[] $faculties
 */

use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\Country;
use ErasmusHelper\Models\Faculty;

?>
<div class="row">
    <div class="box col-12 col-md-6">
        <div class="box-header">
            <span class="box-title">User registration</span>
        </div>
        <form method="POST" action="<?= Router::route('user.create') ?>">
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
                    <div class="label">Name</div>
                    <input name="name" class="value" type="text" value=""/>
                </div>
                <div class="field">
                    <div class="label">Firstname</div>
                    <input name="firstname" class="value" type="text" value=""/>
                </div>
                <div class="field">
                    <div class="label">Country of origin</div>
                    <select name="country_origin_id" class="value">
                        <option disabled>Select a country</option>
                        <?php foreach ($countries as $country): ?>
                            <option value="<?= $country->id; ?>"><?= $country->name; ?></option>
                        <?php endforeach; ?>
                    </select>
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
                    <div class="label">Validation level</div>
                    <select name="validation_level" class="value">
                        <option disabled>Select a level</option>
                        <option value="0">Student unknown</option>
                        <option value="1">Student this semester</option>
                        <option value="2">Student from previous semester(s)</option>
                    </select>
                </div>
            </div>
            <div class="box-footer">
                <div class="button-group">
                    <a href="<?= Router::route('users') ?>" class="button">Cancel</a>
                    <button type="submit" class="button cta">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>