<?php

namespace ErasmusHelper\Models;

use Kreait\Firebase\Exception\DatabaseException;

class Faculty extends Model {

    const STORAGE = 'faculties';

    const COLUMNS = ["id", "name", "city_id"];

    public $name;
    public $city_id;

    /**
     * Returns the country associated to the city.
     *
     * @return City
     * @throws DatabaseException
     */
    public function getCity(): City {
        return City::select(["id" => $this->city_id]);
    }

    /**
     * Returns the list of students associated to this faculty.
     *
     * @return array
     * @throws DatabaseException
     */
    public function getAssociatedStudents(): array {
        return User::getAll(["faculty_id" => $this->id]);
    }

}