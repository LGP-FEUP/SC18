<?php

namespace ErasmusHelper\Models;

use AgileBundle\Database\Model;

class Event extends Model {

    const STORAGE = "events";
    const COLUMNS = [
        "id" => true,
        "name" => false,
        "city_id" => false,
        "available" => false
    ];

}