<?php
/** @var User[] $users */

use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\User;

?>
<div class="row">
    <div class="box no-padding col-12">
        <div class="box-content">
            <div class="table-wrapper">
                <table class="table <?= empty($users) ? 'empty' : '' ?>">
                    <tr>
                        <th>Email Address</th>
                        <th>Lastname</th>
                        <th>Firstname</th>
                        <th>BirthDate</th>
                        <th>Faculty of Origin</th>
                        <th>Faculty of Arrival</th>
                        <th></th>
                    </tr>
                    <?php
                    if(!empty($users)) {
                        foreach ($users as $user): ?>
                            <tr bgcolor="<?= $user->isDisabled() ? "lightgrey" : "white"; ?>">
                                <td><?= $user->getEmail(); ?></td>
                                <td><?= $user->lastname; ?></td>
                                <td><?= $user->firstname; ?></td>
                                <td><?= $user->computeBirthDate(); ?></td>
                                <td><?= $user->getFaculty(false)->name; ?></td>
                                <td><?= $user->getFaculty()->name; ?></td>
                                <td><a class="button" href="<?= Router::route('user', ["id" => $user->id]) ?>"><i class="far fa-eye r"></i>Details</a></td>
                            </tr>
                        <?php endforeach;
                    } ?>
                </table>
            </div>
        </div>
    </div>
</div>