<?php

namespace ErasmusHelper\Models;

use ErasmusHelper\App;
use Kreait\Firebase\Exception\DatabaseException;

class City extends Model {

    const STORAGE = 'cities';

    const COLUMNS = ["id", "name", "country_id"];

    public $name;
    public $country_id;

    /**
     * Returns the country associated to the city.
     *
     * @return Country
     * @throws DatabaseException
     */
    public function getCountry(): Country {
        return Country::select(["id" => $this->country_id]);
    }

    /**
     * Returns the list of faculties associated to this city.
     *
     * @return array
     * @throws DatabaseException
     */
    public function getAssociatedFaculties(): array {
        return Faculty::getAll(["city_id" => $this->id]);
    }

}