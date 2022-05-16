<?php

namespace ErasmusHelper\Models;

use ErasmusHelper\App;
use Kreait\Firebase\Exception\DatabaseException;

class UniversityFaq extends Model
{
    const COLUMNS = ["id", "question", "reply"];

    public $question;
    public $reply;

    /**
     * @throws DatabaseException
     */
    static function getStorage(): string
    {
        return "faculties/" . App::getInstance()->auth->getFaculty()->id . "/faqs";
    }


}