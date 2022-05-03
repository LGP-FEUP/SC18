<?php
/** @var UniModerator[] $staffs */

use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\UniModerator;

?>
<div class="row">
    <div class="box no-padding col-12">
        <div class="box-content">
            <div class="table-wrapper">
                <table class="table <?= empty($staffs) ? 'empty' : '' ?>">
                    <tr>
                        <th>Identifier</th>
                        <th>Email Address</th>
                        <th>Privilege Level</th>
                        <th><a class="button" href="<?= Router::route('staff.create.page') ?>" ><i class="fas fa-plus r"></i>Add a staff member</a></th>
                    </tr>
                    <?php
                    if(!empty($staffs)) {
                        foreach ($staffs as $staff): ?>
                            <tr bgcolor="<?= $staff->disabled ? "lightgrey" : "white"; ?>">
                                <td><?= $staff->id; ?></td>
                                <td><?= $staff->email; ?></td>
                                <td><?= $staff::PRIVILEGE_LEVEL; ?></td>
                                <td><a class="button" href="<?= Router::route('staff', ["id" => $staff->id]) ?>"><i class="far fa-eye r"></i>Details</a></td>
                            </tr>
                        <?php endforeach;
                    } ?>
                </table>
            </div>
        </div>
    </div>
</div>