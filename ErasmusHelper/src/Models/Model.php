<?php

namespace ErasmusHelper\Models;

use AgileBundle\Utils\Dbg;
use ErasmusHelper\App;
use ErasmusHelper\Core\DBConf;
use Exception;
use Kreait\Firebase\Exception\DatabaseException;

abstract class Model {

    /**
     * Storage name
     * @example "users"
     */
    const STORAGE = "";

    /**
     * Columns for such object
     * @example "id", "name", "firstname"...
     */
    const COLUMNS = [];

    public string $id = "";
    private bool $dbStored = false;

    /**
     * Constructs an object. If it comes from database (= $date is nul null), hydrates it.
     * Otherwise, generates a new UUID for this object.
     *
     * @throws Exception
     */
    public function __construct(array $data = null) {
        if($data != null) {
            $this->hydrate($data);
        } else {
            $this->id = App::UUIDGenerator();
        }
    }

    /**
     * Updates or Insert the object with a valid ID into the database.
     *
     * @return bool
     */
    public function save(): bool {
        try {
            App::getInstance()->firebase->database->getReference(static::STORAGE)->getChild($this->id)->set($this->jsonFormat());
            $this->dbStored = true;
            return true;
        } catch (DatabaseException $exception) {
            Dbg::error($exception->getMessage());
            return false;
        }
    }

    /**
     * Removes an object (if it exists) from the database.
     *
     * @return bool
     */
    public function delete(): bool {
        try {
            App::getInstance()->firebase->database->getReference(static::STORAGE)->removeChildren([
                'id' => $this->id
            ]);
            $this->dbStored = false;
            return true;
        } catch (DatabaseException $exception) {
            Dbg::error($exception->getMessage());
            return false;
        }
    }

    /**
     * Returns if an object is currently in the database or not.
     *
     * @return bool
     */
    public function exists(): bool {
        return $this->dbStored;
    }

    /**
     * Hydrates an object coming from the database with its fitting information.
     *
     * @param array $data
     * @return void
     */
    protected function hydrate(array $data) {
        $this->dbStored = true;
        foreach($data as $key => $value) {
            if(in_array($key, array_values(static::COLUMNS)) && property_exists($this, $key)) {
                if (is_bool($this->{$key}) && !is_bool($value)) {
                    $this->{$key} = $value == 1;
                } else if (!is_null(filterDate($value))) {
                    $this->{$key} = filterDate($value);
                } else {
                    $this->{$key} = $value;
                }
            }
        }
    }

    /**
     * Sets an object in proper jsonFormat for it to be inserted into the Database.
     *
     * @return array
     */
    private function jsonFormat(): array {
        $toReturn = array();
        foreach(static::COLUMNS as $key) {
            if(property_exists($this, $key)) {
                $toReturn += [$key => $this->$key];
            }
        }
        return $toReturn;
    }

    /**
     * Returns an array of instantiated objects.
     *
     * @param array|null $where If not null, will only return objects according to the conditions in the array.
     * @throws DatabaseException
     */
    public static function getAll(array $where = null): ?array {
        $all = App::getInstance()->firebase->database->getReference(static::STORAGE)->getValue();
        $toReturn = array();
        Dbg::info("Fetch get all " . static::STORAGE); //TODO remove debug
        if($all > 0) {
            if ($where != null) {
                foreach ($all as $id => $row) {
                    foreach ($where as $request => $reqValue) {
                        if ($row[$request] == $reqValue) {
                            $toReturn[] = $row; //TODO improve
                        }
                    }
                }
            } else {
                foreach ($all as $id => $row) {
                    $toReturn[] = $row;
                }
            }
        }
        if(sizeof($toReturn) == 0) {
            return null;
        } else {
            return DBConf::instantiateAll(static::class, $toReturn);
        }
    }

    /**
     * Selects the first object in the database meeting the where requirements
     *
     * @param array $where
     * @return mixed
     * @throws DatabaseException
     */
    public static function select(array $where): mixed {
        $all = App::getInstance()->firebase->database->getReference(static::STORAGE)->getValue();
        Dbg::info("Fetch select " . static::STORAGE); //TODO remove debug
        if($all > 0) {
            if ($where != null) {
                foreach ($all as $id => $row) {
                    $return = true;
                    foreach ($where as $request => $reqValue) {
                        if ($row[$request] != $reqValue) {
                            $return = false; //TODO improve
                        }
                    }
                    if($return) {
                        return DBConf::instantiate(static::class, $row);
                    }
                }
            }
        }
        return null;
    }

}