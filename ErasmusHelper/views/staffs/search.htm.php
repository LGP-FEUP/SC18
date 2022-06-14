<?php
/** @var StaffModel[] $staffs */

use ErasmusHelper\App;
use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\StaffModel;

if(!empty($staffs)) { ?>
    <div class="row">
        <div class="box no-padding col-12">
            <div class="box-content">
                <div class="table-wrapper">
                    <table class="table">
                        <tr>
                            <th>Identifier</th>
                            <th>Email Address</th>
                            <th>Level</th>
                            <th><a class="button" href="<?= Router::route('staff.create.page') ?>" ><i class="fas fa-plus r"></i>Add a staff member</a></th>
                        </tr>
                        <?php foreach ($staffs as $staff): ?>
                            <tr bgcolor="<?= $staff->disabled ? "lightgrey" : "white"; ?>">
                                <td><?= $staff->id; ?></td>
                                <td><?= $staff->email; ?></td>
                                <td><?= App::getPrivilegeName($staff::PRIVILEGE_LEVEL); ?></td>
                                <td><a class="button" href="<?= Router::route('staff', ["id" => $staff->id]) ?>"><i class="far fa-eye r"></i>Details</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
<label class="label">No result found.</label>
<?php }