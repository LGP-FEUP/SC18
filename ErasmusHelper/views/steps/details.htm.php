<?php
/**
 * @var int $task_id ;
 * @var Step $step ;
 */

use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\Step;

?>
<div class="row">
    <div class="col box">
        <div class="box-header">
            <span class="box-title"><?= $step['name'] ?></span>
        </div>
        <form method="POST"
              action="<?= Router::route('step.edit', ["task_id" => $task_id, "step_id" => $step['id']]) ?>">
            <div class="box-content">
                <div class="field">
                    <div class="label">Name</div>
                    <input name="step-name" class="value" type="text" value="<?= $step['name'] ?>"/>
                </div>
            </div>
            <div class="box-footer">
                <div class="button-group">
                    <a href="<?= Router::route('steps') ?>" class="button">Cancel</a>
                    <a onclick="confirm('Confirm the deletion of the Step item ?') ? window.location = '<?= Router::route('step.delete', ["task_id" => $task_id, "step_id" => $step['id']]) ?>' : void(0)"
                       class="button red">Delete</a>
                    <button type="submit" class="button cta">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>