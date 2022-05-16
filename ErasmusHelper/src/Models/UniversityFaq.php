<?php

namespace ErasmusHelper\Models;

class UniversityFaq extends Model
{
    const STORAGE = 'university_faq';

    const COLUMNS = ["id", "question", "reply"];

    public $question;
    public $reply;


}