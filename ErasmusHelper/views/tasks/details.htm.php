<?php

/**
 * @var int $id ;
 * @var Task $task ;
 */

use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\Task;

?>
<div class="row">
    <div class="box col-12 col-md-6">
        <div class="box-header">
            <span class="box-title"><?= "Edit: $task->when" ?></span>
        </div>
        <form method="POST" action="<?= Router::route('task.edit', ["id" => $task->id]) ?>">
            <div class="box-content">
                <div class="field">
                    <div class="label">Identifier</div>
                    <input name="id" class="value" type="text" value="<?= $task->id; ?>" disabled/>
                </div>
                <div class="field">
                    <div class="label">Name</div>
                    <input name="title" class="value" type="text" value="<?= $task->title; ?>"/>
                </div>
                <div class="field">
                    <div class="label">Before Arrival</div>
                    <input name="when" class="value" type="radio"
                           value="before" <?= $task->when === "before" ? "checked" : "" ?>/>
                </div>
                <div class="field">
                    <div class="label">During Stay</div>
                    <input name="when" class="value" type="radio"
                           value="during"<?= $task->when === "during" ? "checked" : "" ?>/>
                </div>
                <div class="field">
                    <div class="label">After Departure</div>
                    <input name="when" class="value" type="radio"
                           value="after" <?= $task->when === "after" ? "checked" : "" ?>/>
                </div>
                <div class="field">
                    <div class="label">Deadline</div>
                    <input name="due_date" class="value"
                           value="<?= $task->due_date ? date("Y-m-d", strtotime($task->due_date['date'])) : "" ?>"
                           type="date"/>
                </div>
            </div>
            <div class="box-footer">
                <div class="button-group">
                    <a href="<?= Router::route('tasks') ?>" class="button">Cancel</a>
                    <?php if (empty($cities)) { ?>
                        <a onclick="confirm('Confirm the deletion of the task Item ?') ? window.location = '<?= Router::route('task.delete', ["id" => $task->id]) ?>' : void(0)"
                           class="button red">Delete</a>
                    <?php } ?>
                    <button type="submit" class="button cta">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-12 col-md-6">
        <div class="box mb-5">
            <div class="box-header">
                <span class="box-title"><?= "Add new Sub Task" ?></span>
            </div>
            <form method="POST" action="<?= Router::route('step.create') ?>">
                <input type="hidden" name="taskId" value="<?= $task->id ?>">
                <div class="box-content">
                    <div class="field">
                        <div class="label">Sub Task Name</div>
                        <input name="step-name" class="value" type="text"/>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="button-group">
                        <button type="submit" class="button cta">Submit</button>
                    </div>
                </div>
            </form>
        </div>
        <?php if ($task->steps) { ?>
            <div class="box">
                <div class="box-header">
                    <span class="box-title">Sub Tasks</span>
                </div>
                <div class="box-content">
                    <div class="table-wrapper">
                        <table class="table">
                            <tr>
                                <th>Identifier</th>
                                <th>Name</th>
                                <th>More Info</th>
                            </tr>
                            <?php foreach ($task->steps as $step) { ?>
                                <tr>
                                    <td><?= $step['id']; ?></td>
                                    <td><?= $step['name']; ?></td>
                                    <td><a class="button"
                                           href="<?= Router::route('step', ["id" => $step['id']]) ?>"><i
                                                    class="far fa-eye r"></i>Details</a></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
</div>
