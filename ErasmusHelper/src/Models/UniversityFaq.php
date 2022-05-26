<?php

namespace ErasmusHelper\Models;

use ErasmusHelper\App;
use Kreait\Firebase\Exception\DatabaseException;

class UniversityFaq extends Model
{
    const COLUMNS = ["id", "question", "reply", "order"];

    public $question;
    public $reply;
    public $order;

    static function getStorage(): string {
        return "faculties/" . App::getInstance()->auth->getFaculty()->id . "/faqs";
    }


}