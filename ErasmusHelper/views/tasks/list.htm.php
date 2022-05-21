<?php
/** @var Task[] $tasks */

use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\Task;

?>

<div class="row">
    <div class="box no-padding col-12">
        <div class="box-content">
            <div class="table-wrapper">
                <table class="table <?= empty($tasks) ? 'empty' : '' ?>">
                    <tr>
                        <th>Identifier</th>
                        <th>Task</th>
                        <th>Class</th>
                        <th>Deadline</th>
                        <th>Number steps</th>
                        <th><a class="button" href="<?= Router::route('task.create.page') ?>"><i
                                        class="fas fa-plus r"></i>Add a new Item</a></th>
                    </tr>
                    <?php
                    if (!empty($tasks)) {
                        foreach ($tasks as $task): ?>
                            <tr>
                                <td><?= $task->id; ?></td>
                                <td><?= $task->when; ?></td>
                                <td><?= $task->when; ?></td>
                                <td><?= $task->due_date ? date("Y-m-d", strtotime($task->due_date['date'])) : "" ?></td>
                                <td><?= isset($task->steps) ? count($task->steps) : "Without steps" ?></td>
                                <td><a class="button"
                                       href="<?= Router::route('task', ["id" => $task->id]) ?>"><i
                                                class="far fa-eye r"></i>Details</a></td>
                            </tr>
                        <?php endforeach;
                    } ?>
                </table>
            </div>
        </div>
    </div>
</div>
