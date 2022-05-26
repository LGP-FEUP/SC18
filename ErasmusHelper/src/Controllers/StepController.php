<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Request;
use ErasmusHelper\App;
use ErasmusHelper\Models\Task;
use ErasmusHelper\Models\Step;
use JetBrains\PhpStorm\NoReturn;
use Kreait\Firebase\Exception\DatabaseException;

class StepController extends UniModsBackOfficeController {

    protected string $title = "Steps";

    #[NoReturn] public function createStep()
    {
        try {
            if (Request::valuePost('taskId') && Request::valuePost('step-name')) {

                $task = Task::select(["id" => Request::valuePost('taskId')]);

                if ($task != null) {
                    $step = new Step();

                    $step->id = App::UUIDGenerator();
                    $step->name = Request::valuePost('step-name');

                    $task->steps[] = $step;

                    if ($task->save())
                        $this->redirect(Router::route("task", ["id" => Request::valuePost('taskId')]), ["success" => "Step added successfully."]);
                }
            }
            $this->redirect(Router::route("task", ["id" => Request::valuePost('taskId')]), ["error" => "Unable to add the Task item."]);
        } catch (DatabaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }

    }

    public function edit($task_id, $step_id)
    {
        $task = Task::select(["id" => $task_id]);
        foreach ($task->steps as $item) {
            if ($item['id'] == $step_id) {
                $step = $item;
                break;
            }
        }
        $this->render("steps.details", ["task_id" => $task->id, "step" => $step]);
    }

    #[NoReturn] public function editStep($task_id, $step_id)
    {
        try {
            $task = Task::select(["id" => $task_id]);
            $new_steps = [];

            if ($task != null && $task->exists() && Request::valuePost('step-name')) {
                foreach ($task->steps as $step) {
                    if ($step['id'] == $step_id)
                        $step['name'] = Request::valuePost('step-name');

                    $new_steps[] = $step;
                }

                $task->steps = $new_steps;

                if ($task->save())
                    $this->redirect(Router::route("task", ["id" => $task->id]), ["success" => "Step edited successfully."]);
            }

            $this->redirect(Router::route("tasks"), ["error" => "Unable to edit the Step item."]);
        } catch (DatabaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);

        }
    }

    #[NoReturn] public function delete($task_id, $step_id)
    {
        try {
            $task = Task::select(["id" => $task_id]);
            $new_steps = [];

            if ($task != null && $task->exists()) {
                foreach ($task->steps as $step) {
                    if ($step['id'] == $step_id)
                        continue;

                    $new_steps[] = $step;
                }

                $task->steps = $new_steps;

                if ($task->save())
                    $this->redirect(Router::route("task", ["id" => $task->id]), ["success" => "Step edited successfully."]);

            }
            $this->redirect(Router::route("tasks"), ["error" => "Unable to edit the Step item."]);
        } catch (DatabaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }

}