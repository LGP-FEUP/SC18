<?php

namespace ErasmusHelper\Models;

use AgileBundle\Utils\Dbg;
use Kreait\Firebase\Exception\DatabaseException;

class Faculty extends Model
{

    const STORAGE = 'faculties';

    const COLUMNS = ["id", "name", "city_id", "tasks", "code"];

    public $name;
    public $city_id;
    public $tasks;
    public $code;

    /**
     * Returns the city associated to the faculty.
     *
     * @return ?City
     */
    public function getCity(): ?City
    {
        return City::select(["id" => $this->city_id]);
    }

    /**
     * Returns the list of students associated to this faculty.
     *
     * @return ?array
     */
    public function getAssociatedStudents(): ?array
    {
        return User::getAll(["faculty_id" => $this->id]);
    }

    /**
     * Returns the list of faculties for a country.
     *
     * @param Country $country
     * @return ?array
     */
    public static function getAllByCountry(Country $country): ?array {
        try {
            $toReturn = array();
            $faculties = Faculty::getAll();
            foreach ($faculties as $faculty) {
                $countryFac = $faculty->getCity()->getCountry();
                if ($countryFac == $country) {
                    $toReturn[] = $faculty;
                }
            }
            return $toReturn;
        } catch (DatabaseException $e) {
            Dbg::error($e->getMessage());
            return null;
        }
    }
}