<?php

namespace ErasmusHelper\Models;

use Kreait\Firebase\Exception\DatabaseException;

class Country extends Model {

    const STORAGE = 'countries';

    const COLUMNS = ["id", "name"];

    public $name;

    /**
     * Returns the list of cities associated to this country.
     *
     * @return array
     * @throws DatabaseException
     */
    public function getAssociatedCities(): array {
        return City::getAll(["country_id" => $this->id]);
    }
}