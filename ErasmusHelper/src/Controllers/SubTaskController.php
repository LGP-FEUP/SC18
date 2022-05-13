<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Request;
use ErasmusHelper\App;
use ErasmusHelper\Models\Bureaucracy;
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
        if (Request::valuePost('bureaucracyId') && Request::valuePost('task-name')) {

            $bureaucracy = Bureaucracy::select(["id" => Request::valuePost('bureaucracyId')]);

            if ($bureaucracy != null && $bureaucracy->exists()) {
                $subTask = new SubTask();

                $subTask->id = App::UUIDGenerator();
                $subTask->name = Request::valuePost('task-name');

                # TODO: Fix this bug that automatically updates the type of object to a Firebase Datetime that breaks the PHP Datetimes
                $bureaucracy->deadline = date('Y-m-d', strtotime($bureaucracy->deadline->format('Y-m-d')));
                #

                $bureaucracy->list_subtasks[] = $subTask;

                if ($bureaucracy->save())
                    $this->redirect(Router::route("bureaucracy", ["id" => Request::valuePost('bureaucracyId')]), ["success" => "SubTask added successfully."]);
            }
        }

        $this->redirect(Router::route("bureaucracy", ["id" => Request::valuePost('bureaucracyId')]), ["error" => "Unable to add the Bureaucracy item."]);

    }

    /**
     * @throws DatabaseException
     */
    public function editSubTask($bureaucracyId, $subtaskId)
    {
        $bureaucracy = Bureaucracy::select($bureaucracyId);


        if ($bureaucracy != null && $bureaucracy->exists() && Request::valuePost('task-name')) {
            foreach ($bureaucracy->subTasks as $subTask) {
                if ($subTask->id == $subtaskId) {
                    $subTask->name = Request::valuePost('task-name');
                    break;
                }
            }
        }
    }

}