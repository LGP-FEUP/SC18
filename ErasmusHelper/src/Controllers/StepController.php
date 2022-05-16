<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Request;
use ErasmusHelper\App;
use ErasmusHelper\Models\Task;
use ErasmusHelper\Models\Step;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Kreait\Firebase\Exception\DatabaseException;

class StepController extends Controller
{

    /**
     * @throws DatabaseException
     * @throws Exception
     */
    #[NoReturn] public function createStep()
    {
        if (Request::valuePost('taskId') && Request::valuePost('step-name')) {

            $task = Task::select(["id" => Request::valuePost('taskId')]);

            if ($task != null) {
                $step = new Step();

                $step->id = App::UUIDGenerator();
                $step->title = Request::valuePost('step-name');

                $task->steps[] = $step;

                if ($task->save())
                    $this->redirect(Router::route("task", ["id" => Request::valuePost('taskId')]), ["success" => "Step added successfully."]);
            }
        }

        $this->redirect(Router::route("task", ["id" => Request::valuePost('taskId')]), ["error" => "Unable to add the Task item."]);

    }

    /**
     * @throws DatabaseException
     */
    public function editStep($taskId, $stepId)
    {
        $task = Task::select($taskId);


        if ($task != null && $task->exists() && Request::valuePost('task-name')) {
            foreach ($task->step as $step) {
                if ($step->id == $stepId) {
                    $step->title = Request::valuePost('step-name');
                    break;
                }
            }
        }
    }

}