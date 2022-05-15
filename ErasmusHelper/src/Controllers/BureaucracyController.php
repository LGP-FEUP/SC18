<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Request;
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

            if (Request::valuePost("deadline"))
                $bureaucracy->deadline = Request::valuePost("deadline");

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
        $this->render("bureaucracies.details", ["id" => $id, "bureaucracy" => Bureaucracy::select($id)]);
    }

}