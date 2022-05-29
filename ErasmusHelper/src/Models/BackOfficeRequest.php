<?php

namespace ErasmusHelper\Models;

class BackOfficeRequest extends Model {

    const STORAGE = 'backoffice-requests';

    const COLUMNS = ["id", "title", "content", "author", "date", "status"];

    public $title;
    public $content;
    public $author;
    public $date;
    public $status;
}