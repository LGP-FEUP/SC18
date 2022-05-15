<?php
/** @var Bureaucracy[] $bureaucracies */

use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\Bureaucracy;

?>

<div class="row">
    <div class="box no-padding col-12">
        <div class="box-content">
            <div class="table-wrapper">
                <table class="table <?= empty($bureaucracies) ? 'empty' : '' ?>">
                    <tr>
                        <th>Identifier</th>
                        <th>Task</th>
                        <th>Class</th>
                        <th>Deadline</th>
                        <th>Number Subtasks</th>
                        <th><a class="button" href="<?= Router::route('bureaucracy.create.page') ?>"><i
                                        class="fas fa-plus r"></i>Add a new Item</a></th>
                    </tr>
                    <?php
                    if (!empty($bureaucracies)) {
                        foreach ($bureaucracies as $bureaucracy): ?>
                            <tr>
                                <td><?= $bureaucracy->id; ?></td>
                                <td><?= $bureaucracy->task; ?></td>
                                <td><?= $bureaucracy->class; ?></td>
                                <td><?= isset($bureaucracy->deadline) ? $bureaucracy->deadline->format('Y-m-d') : "No Deadline Defined" ?></td>
                                <td><?= isset($bureaucracy->list_subtasks) ? count($bureaucracy->list_subtasks) : "Without Subtasks" ?></td>
                                <td><a class="button"
                                       href="<?= Router::route('bureaucracy', ["id" => $bureaucracy->id]) ?>"><i
                                                class="far fa-eye r"></i>Details</a></td>
                            </tr>
                        <?php endforeach;
                    } ?>
                </table>
            </div>
        </div>
    </div>
</div>
