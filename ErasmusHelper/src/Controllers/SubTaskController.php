<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Request;
use ErasmusHelper\App;
use ErasmusHelper\Models\Task;
use ErasmusHelper\Models\SubTask;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Kreait\Firebase\Exception\DatabaseException;

class SubTaskController extends Controller
{

    /**
     * @throws DatabaseException
     * @throws Exception
     */
    #[NoReturn] public function createSubTask()
    {
        if (Request::valuePost('taskId') && Request::valuePost('task-name')) {

            $task = Task::select(["id" => Request::valuePost('taskId')]);

            if ($task != null && $task->exists()) {
                $subTask = new SubTask();

                $subTask->id = App::UUIDGenerator();
                $subTask->name = Request::valuePost('task-name');
                

                $task->list_subtasks[] = $subTask;

                if ($task->save())
                    $this->redirect(Router::route("task", ["id" => Request::valuePost('taskId')]), ["success" => "SubTask added successfully."]);
            }
        }

        $this->redirect(Router::route("task", ["id" => Request::valuePost('taskId')]), ["error" => "Unable to add the Task item."]);

    }

    /**
     * @throws DatabaseException
     */
    public function editSubTask($taskId, $subtaskId)
    {
        $task = Task::select($taskId);


        if ($task != null && $task->exists() && Request::valuePost('task-name')) {
            foreach ($task->subTasks as $subTask) {
                if ($subTask->id == $subtaskId) {
                    $subTask->name = Request::valuePost('task-name');
                    break;
                }
            }
        }
    }

}