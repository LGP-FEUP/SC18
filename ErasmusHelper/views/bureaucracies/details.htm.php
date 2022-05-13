<?php

/**
 * @var int $id ;
 * @var Bureaucracy $bureaucracy ;
 */

use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\Bureaucracy;

?>
<div class="row">
    <div class="box col-12 col-md-6">
        <div class="box-header">
            <span class="box-title"><?= "Edit: $bureaucracy->task" ?></span>
        </div>
        <form method="POST" action="<?= Router::route('bureaucracy.edit', ["id" => $bureaucracy->id]) ?>">
            <div class="box-content">
                <div class="field">
                    <div class="label">Identifier</div>
                    <input name="id" class="value" type="text" value="<?= $bureaucracy->id; ?>" disabled/>
                </div>
                <div class="field">
                    <div class="label">Name</div>
                    <input name="task" class="value" type="text" value="<?= $bureaucracy->task; ?>"/>
                </div>
                <div class="field">
                    <div class="label">Before Arrival</div>
                    <input name="class" class="value" type="radio"
                           value="before" <?= $bureaucracy->class === "before" ? "checked" : "" ?>/>
                </div>
                <div class="field">
                    <div class="label">During Stay</div>
                    <input name="class" class="value" type="radio"
                           value="during"<?= $bureaucracy->class === "during" ? "checked" : "" ?>/>
                </div>
                <div class="field">
                    <div class="label">After Departure</div>
                    <input name="class" class="value" type="radio"
                           value="after" <?= $bureaucracy->class === "after" ? "checked" : "" ?>/>
                </div>
                <div class="field">
                    <div class="label">Deadline</div>
                    <input name="deadline" class="value" value="<?= $bureaucracy->deadline->format('Y-m-d'); ?>"
                           type="date"/>
                </div>
            </div>
            <div class="box-footer">
                <div class="button-group">
                    <a href="<?= Router::route('bureaucracies') ?>" class="button">Cancel</a>
                    <?php if (empty($cities)) { ?>
                        <a onclick="confirm('Confirm the deletion of the Bureaucracy Item ?') ? window.location = '<?= Router::route('bureaucracy.delete', ["id" => $bureaucracy->id]) ?>' : void(0)"
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
            <form method="POST" action="<?= Router::route('subtask.create') ?>">
                <input type="hidden" name="bureaucracyId" value="<?= $bureaucracy->id ?>">
                <div class="box-content">
                    <div class="field">
                        <div class="label">Sub Task Name</div>
                        <input name="task-name" class="value" type="text"/>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="button-group">
                        <button type="submit" class="button cta">Submit</button>
                    </div>
                </div>
            </form>
        </div>
        <?php if ($bureaucracy->list_subtasks) { ?>
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
                            <?php foreach ($bureaucracy->list_subtasks as $subtask) { ?>
                                <tr>
                                    <td><?= $subtask['id']; ?></td>
                                    <td><?= $subtask['name']; ?></td>
                                    <td><a class="button"
                                           href="<?= Router::route('subtask', ["id" => $subtask['id']]) ?>"><i
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
