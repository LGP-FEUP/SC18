<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Request;
use DateTime;
use ErasmusHelper\App;
use ErasmusHelper\Models\Bureaucracy;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Kreait\Firebase\Exception\DatabaseException;

class BureaucracyController extends UniModsBackOfficeController
{
    /**
     * @throws DatabaseException
     */
    public function displayAll()
    {
        $this->render("bureaucracies.list", ["bureaucracies" => Bureaucracy::getAll()]);
    }

    public function create()
    {
        $this->render("bureaucracies.create");
    }

    /**
     * @throws Exception
     */
    #[NoReturn] public function createBureaucracy()
    {
        $bureaucracy = new Bureaucracy();
        if (Request::valuePost("name") && Request::valuePost("class")) {
            $bureaucracy->id = App::UUIDGenerator();
            $bureaucracy->task = Request::valuePost("name");
            $bureaucracy->class = Request::valuePost("class");

            if (Request::valuePost("deadline")) {
                $datetime = new DateTime(Request::valuePost('deadline'));
                $bureaucracy->deadline = $datetime->getTimestamp();
            }

            if ($bureaucracy->save()) {
                $this->redirect(Router::route("bureaucracy", ["id" => $bureaucracy->id]), ["success" => "Bureaucracy added successfully."]);
            }
        }
        $this->redirect(Router::route("bureaucracies"), ["error" => "Unable to add the Bureaucracy item."]);
    }

    /**
     * @throws DatabaseException
     */
    public function edit($id)
    {
        $this->render("bureaucracies.details", ["id" => $id, "bureaucracy" => Bureaucracy::select(["id" => $id])]);
    }

    /**
     * @throws DatabaseException
     * @throws Exception
     */
    #[NoReturn] public function editBureaucracy($id)
    {
        $bureaucracy = Bureaucracy::select(["id" => $id]);

        if ($bureaucracy != null && $bureaucracy->exists()) {
            if (Request::valuePost('task'))
                $bureaucracy->task = Request::valuePost('task');

            if (Request::valuePost('class'))
                $bureaucracy->class = Request::valuePost('class');

            if (Request::valuePost("deadline")) {
                $datetime = new DateTime(Request::valuePost('deadline'));
                $bureaucracy->deadline = $datetime->getTimestamp();
            }

            if ($bureaucracy->save()) {
                $this->redirect(Router::route("bureaucracy", ["id" => $bureaucracy->id]), ["success" => "Bureaucracy edited successfully."]);
            }
        }
        $this->redirect(Router::route("bureaucracies"), ["error" => "Unable to edit the Bureaucracy item."]);
    }

    /**
     * @throws DatabaseException
     */
    #[NoReturn] public function delete($id)
    {
        $bureaucracy = Bureaucracy::select(["id" => $id]);

        if ($bureaucracy != null && $bureaucracy->exists()) {
            if ($bureaucracy->delete())
                $this->redirect(Router::route('bureaucracies'), ['success' => "Task Deleted with Success"]);

        }

        $this->redirect(Router::route('bureaucracies'), ['error' => "Task Failed to Delete"]);
    }

}