<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Request;
use DateTime;
use ErasmusHelper\App;
use ErasmusHelper\Models\Task;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Kreait\Firebase\Exception\DatabaseException;

class TaskController extends UniModsBackOfficeController {

    protected string $title = "Tasks";

    public function displayAll()
    {
        $this->render("tasks.list", ["tasks" => Task::getAll()]);
    }

    public function create()
    {
        $this->render("tasks.create");
    }

    #[NoReturn] public function createTask()
    {
        try {
            $task = new Task();
            if (Request::valuePost("title") && Request::valuePost("when")) {
                $task->id = App::UUIDGenerator();
                $task->title = Request::valuePost("title");
                $task->when = Request::valuePost("when");

                if (Request::valuePost("description"))
                    $task->description = Request::valuePost('description');

                if (Request::valuePost("due_date"))
                    $task->due_date = new DateTime(Request::valuePost('due_date'));

                if ($task->save())
                    $this->redirect(Router::route("task", ["id" => $task->id]), ["success" => "Task added successfully."]);

            }
            $this->redirect(Router::route("tasks"), ["error" => "Unable to add the Task item."]);
        } catch (Exception $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }

    public function edit($id)
    {
        $this->render("tasks.details", ["id" => $id, "task" => Task::select(["id" => $id])]);
    }

    #[NoReturn] public function editTask($id)
    {
        try {
            $task = Task::select(["id" => $id]);

            if ($task != null && $task->exists()) {
                if (Request::valuePost('title'))
                    $task->title = Request::valuePost('title');

                if (Request::valuePost('when'))
                    $task->when = Request::valuePost('when');

                if (Request::valuePost("description"))
                    $task->description = Request::valuePost('description');

                if (Request::valuePost("due_date"))
                    $task->due_date = new DateTime(Request::valuePost('due_date'));

                if ($task->save())
                    $this->redirect(Router::route("task", ["id" => $task->id]), ["success" => "Task edited successfully."]);

            }
            $this->redirect(Router::route("tasks"), ["error" => "Unable to edit the Task item."]);
        } catch (Exception|DatabaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);
        }
    }

    #[NoReturn] public function delete($id)
    {
        try {
            $task = Task::select(["id" => $id]);

            if ($task != null && $task->exists()) {
                if ($task->delete())
                    $this->redirect(Router::route('tasks'), ['success' => "Task Deleted with Success"]);

            }

            $this->redirect(Router::route('tasks'), ['error' => "Task Failed to Delete"]);
        } catch (DatabaseException $e) {
            $this->redirect(Router::route("/"), ["error" => $e]);

        }
    }

}