<?php

namespace ErasmusHelper\Models;

use ErasmusHelper\App;
use Kreait\Firebase\Exception\DatabaseException;

class Task extends Model
{
    const COLUMNS = ["id", "title", "description", "when", "due_date", "steps"];

    public $title;
    public $description;
    public $when;
    public $steps;
    public $due_date;

    static function getStorage(): string {
        return "faculties/" . App::getInstance()->auth->getFaculty()->id . "/tasks";
    }


}