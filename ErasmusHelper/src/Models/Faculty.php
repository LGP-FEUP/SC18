<?php

namespace ErasmusHelper\Models;

use Kreait\Firebase\Exception\DatabaseException;

class Faculty extends Model {

    const STORAGE = 'faculties';

    const COLUMNS = ["id", "name", "city_id"];

    public $name;
    public $city_id;

    /**
     * Returns the city associated to the faculty.
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

    /**
     * Returns the list of faculties for a country.
     *
     * @param Country $country
     * @return array
     * @throws DatabaseException
     */
    public static function getAllByCountry(Country $country): array {
        $toReturn = array();
        $faculties = Faculty::getAll();
        foreach($faculties as $faculty) {
            $countryFac = $faculty->getCity()->getCountry();
            if($countryFac == $country) {
                $toReturn[] = $faculty;
            }
        }
        return $toReturn;
    }
}