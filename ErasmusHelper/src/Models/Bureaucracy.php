<?php

namespace ErasmusHelper\Models;

class Bureaucracy extends Model
{
    const STORAGE = 'bureaucracies';

    const COLUMNS = ["id", "task", "class", "deadline", "list_subtasks"];

    public $task;
    public $deadline;
    public $class;
    public $list_subtasks;

}