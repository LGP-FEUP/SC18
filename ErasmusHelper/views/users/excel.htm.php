<?php

use ErasmusHelper\Controllers\ExcelController;
use ErasmusHelper\Controllers\Router; ?>
<div class="row">
    <div class="box col-12">
        <form method="POST" action="<?= Router::route('users.excel.create') ?>" enctype="multipart/form-data">
            <div class="box-content">
                <div class="field">
                    <div class="label">.xls and .xlsx supported: </div>
                    <input type="file" accept=".xls,.xlsx" name="excel" required/>
                </div>
                <div class="field">
                    <div class="label">OPTIONAL: Enter the headers from the first line (please fill all the fields).</div>
                </div>
                <div class="card-columns" >
                    <div class="field">
                        <div class="label">Email header</div>
                        <input name="email" class="input" type="text" placeholder="<?= "E-mail" ?>"/>
                    </div>
                    <div class="field">
                        <div class="label">Firstname header</div>
                        <input name="firstname" class="input" type="text" placeholder="<?= "Firstname" ?>"/>
                    </div>
                    <div class="field">
                        <div class="label">Lastname header</div>
                        <input name="lastname" class="input" type="text" placeholder="<?= "Lastname" ?>"/>
                    </div>
                    <div class="field">
                        <div class="label">Date of birth header</div>
                        <input name="date_of_birth" class="input" type="text" placeholder="<?= "Date of birth" ?>"/>
                    </div>
                    <div class="field">
                        <div class="label">Origin University header</div>
                        <input name="origin_university" class="input" type="text" placeholder="<?= "Origin University" ?>"/>
                    </div>
                    <div class="field">
                        <div class="label">Origin University Code header</div>
                        <input name="origin_university_code" class="input" type="text" placeholder="<?= "Origin University Code" ?>"/>
                    </div>
                    <div class="field">
                        <div class="label">Origin University City header</div>
                        <input name="city_of_origin_university" class="input" type="text" placeholder="<?= "City of Origin University" ?>"/>
                    </div>
                    <div class="field">
                        <div class="label">Origin University Country header</div>
                        <input name="country_of_origin_university" class="input" type="text" placeholder="<?= "Country of Origin University" ?>"/>
                    </div>
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