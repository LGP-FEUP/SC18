<?php

namespace AgileBundle\Database;

use AgileBundle\Strings\Plural;
use AgileBundle\Strings\Strings;
use AgileBundle\Utils\Dbg;
use DateTime;
use JetBrains\PhpStorm\Pure;
use PDO;
use PDOStatement;

/**
 * Class Model
 * Database object modelization
 *
 * @package AgileBundle\Database
 */
abstract class Model {

    /**
     * Object table name
     *
     * @const string
     * @example "entity"
     */
    const STORAGE = "";

    /**
     * Linked tables used for select, pagination...
     *
     * @const array
     * @example [
     *    [Basket::class => "id", Command::class => "basket_id"],
     *    [User::class => "id", Basket::class => "user_id"],
     *    [BasketEntry::class => "basket_id", Basket::class => "id"]
     * ]
     */
    const SQL_JOINS = [];

    /**
     * Object columns
     *
     * @const array
     * @example ["id", "name", "date"...]
     */
    const COLUMNS = [];

    /**
     * Conditions determining either if the object is valid or not, keys must in COLUMNS const, values are
     * functions taking the value in parameter returning null if the value is not correct or the value if it is correct
     *
     * @const array
     * @example [
     *    "name" => "filterString",
     *    "date" => "filterDate",
     *    ...
     * ]
     */
    const CONDITIONS = [];

    /**
     * Pagination limit when retrieving the object
     *
     * @const int
     * @example 15
     */
    const PAGE_LIMIT = 15;

    /**
     * Object unique identifier. Must be defined as a primary key in the SQL linked database
     *
     * @var int
     * @important If the id is at 0, the object is not yet inserted in the database, please refer to the exists method
     */
    public int $id = 0;

    /**
     * Array containing all of the values passed in the hydrate method that are not in the COLUMNS const
     *
     * @var array
     */
    public array $additional_data = [];

    /**
     * Model constructor.
     *
     * @param array|int $data Data as associative array (object fields) or as int (object identifier)
     */
    public function __construct(int|array $data){
        if(is_array($data)){
            $this->hydrate($data);
        } else {
            $id = (int)$data;
            if ($id > 0) {
                $this->id = $id;
                $this->load();
            }
        }
    }

    /**
     * Fetch DB data for the object and then hydrate it
     */
    private function load(){
        $req = SQL::select(static::STORAGE, ["id" => $this->id]);
        if($req->rowCount() > 0){
            $this->hydrate($req->fetch(PDO::FETCH_ASSOC));
        } else {
            $this->id = 0;
        }
    }

    /**
     * Insert or update the object in the DB
     */
    public function save(){
        if(!$this->exists()){
            $this->id = SQL::insert(static::STORAGE, $this->toInitialArray());
        } else {
            SQL::update(static::STORAGE, $this->toInitialArray(), ["id" => $this->id]);
        }
    }

    /**
     * Delete the object from DB
     */
    public function delete(){
        if($this->id > 0){
            SQL::delete($this::STORAGE, ["id" => $this->id]);
        }
    }

    /**
     * Build the SQL save array
     *
     * @return array
     */
    #[Pure] private function toInitialArray(): array {
        $values = [];
        if(!empty(static::getColumns())){
            foreach (static::getColumns() as $column){
                $values[$column] = $this->{$column};
            }
        }
        return $values;
    }

    /**
     * Build an array representing the object, including SQL columns, additional_data and DateTime stamps
     *
     * @return array
     */
    #[Pure] public function toArray(): array {
        $values = self::toInitialArray();
         foreach (static::getColumns() as $column) {
             if ($this->{$column} instanceof DateTime) {
                 $values[$column . "_stamp"] = $this->{$column}->getTimestamp();
             }
         }
         foreach ($this->additional_data as $k => $v) {
             if ($v instanceof DateTime) {
                 $this->additional_data[$k . "_stamp"] = $v->getTimestamp();
             }
         }
        $values["additional_data"] = $this->additional_data;
        return $values;
    }

    /**
     * Hydrate the object, filling his fields according to data parameter, every field that is not present in the
     * columns array will be put in the additional_data array.
     *
     * @param $data []
     */
    public function hydrate($data){
        if($data != false){
            foreach ($data as $key => $value){
                if(in_array($key, array_values(static::COLUMNS)) && property_exists($this, $key)) {
                    if(is_bool($this->{$key}) && !is_bool($value)) {
                        $this->{$key} = $value == 1;
                    } else if(!is_null(filterDate($value))){
                        $this->{$key} = filterDate($value);
                    } else {
                        $this->{$key} = $value;
                    }
                } else {
                    if(!is_null(filterDate($value))){
                        $this->additional_data[$key] = filterDate($value);
                    } else {
                        $this->additional_data[$key] = $value;
                    }
                }
            }
        }
    }

    /**
     * Retrieve all instances of the current model according to specified parameters
     *
     * @param array|string $where
     * @param null $order
     * @param null $limit
     * @param null $offset
     * @param array|string $joinTables
     * @return static[]
     */
    public static function getAll(string|array $where = [], $order = null, $limit = null, $offset = null, array|string $joinTables = []): array {
        return SQL::instantiateAll(SQL::select(
            static::STORAGE, where: $where, order: $order, limit: $limit, offset: $offset, joinTables: $joinTables
        ), static::class);
    }

    /**
     * Retourne la liste des objets paginés
     *
     * @param $page
     * @param null $order
     * @param array $filter
     * @return static[]
     */
    public static function page($page, $order=null, $filter = []): array {
        $joinStr = "";
        foreach (static::SQL_JOINS as $join){
            $class1 = array_keys($join)[0];
            $class1As = Plural::singularize($class1::STORAGE);
            $var1 = $class1 == static::class ? $join[$class1] : Plural::singularize($class1::STORAGE) . "." . $join[$class1];

            $class2 = array_keys($join)[1];
            $var2 = $class2 == static::class ? $join[$class2] : Plural::singularize($class2::STORAGE) . "." . $join[$class2];

            $joinStr .= " LEFT JOIN " . $class1::STORAGE . " AS $class1As ON $var1 = $var2 ";
        }
        return static::getAll($filter, order: $order, limit: static::PAGE_LIMIT, offset: $page*static::PAGE_LIMIT, joinTables: $joinStr);
    }

    /**
     * Search and return an array of the static model according to the 'query' filter parameter
     * The function will just apply a LIKE to all the columns of the model with the query filter
     *
     * @param $query
     * @param ?string $order
     * @param ?int $limit
     * @param ?int $offset
     * @return static[]
     */
    public static function search($query, $order = null, $limit = null, $offset = null) : array {
        return SQL::instantiateAll(SQL::search(
            static::STORAGE, static::getColumns(), $query, $order, $limit, $offset
        ), static::class);
    }

    /**
     * Search and return a static model or null if no models have been found using the filter parameter 'where'.
     *
     * @param $where
     * @param ?string $order
     * @param ?int $limit
     * @param ?int $offset
     * @param array|string $join_tables
     * @return static
     */
    public static function select($where, $order = null, $limit = null, $offset = null, $join_tables = []) : static {
        return SQL::instantiate(SQL::select(
            static::STORAGE, where: $where, order: $order, limit: $limit, offset: $offset, joinTables: $join_tables
        ), static::class);
    }

    /**
     * Update the current model in the db according to current fields values.
     *
     * @param $data
     * @param $where
     * @return false|PDOStatement
     */
    public static function update($data, $where): bool|PDOStatement {
        return SQL::update(static::STORAGE, $data, $where);
    }

    /**
     * Count how many static objects are in the database
     *
     * @param $where
     * @return int
     */
    public static function count($where = []) : int {
        return SQL::select(
            static::STORAGE, $where, additionalSelect: ["count(".static::STORAGE.".id) AS counter"]
        )->fetch(PDO::FETCH_ASSOC)["counter"];
    }

    /**
     * Return the last static object inserted in the database
     *
     * @return ?static
     */
    public static function getLatest() : ?static {
        $tbName = static::STORAGE;
        $rec = SQL::select(static::STORAGE, "id = (SELECT MAX(id) FROM $tbName)");
        if ($rec->rowCount() > 0) {
            return SQL::instantiate($rec, static::class);
        } else return null;
    }

    /**
     * Check if the actual static object either exists in the database or not
     *
     * @return bool
     */
    public function exists(): bool {
        return $this->id > 0;
    }

    /**
     * Check if the actual static object is valid according to the filters defined in the CONDITIONS const
     *
     * @param null $key
     * @return bool|int|string
     */
    public function isValid($key = null): bool|int|string {
        foreach ((is_null($key) ? static::CONDITIONS : [$key => static::CONDITIONS[$key]]) as $key => $condition) {
            if (is_string($condition) || is_int($condition)) {
                // If it's an int it's a simple filter_var default condition
                if (is_int($condition)) {
                    if (is_null(filter_var($this->{$key}, $condition, ['flags' => FILTER_NULL_ON_FAILURE]))) return $key;
                } else {
                    // If the condition is a regex, then we just check for the preg_match
                    if (Strings::startsWith($condition, "/") && Strings::endsWith($condition, "/")) {
                        if (!preg_match($condition, $this->{$key})) return $key;
                    } else {
                        // If it's a string but not a regex, it's a complex condition with parameters
                        $params = explode(" ", $condition);
                        if (in_array("nullable", $params)) {
                            if (!is_null($this->{$key}) && is_null(filter_var($this->{$key}, FILTER_CALLBACK, ['options' => $params[0], 'flags' => FILTER_NULL_ON_FAILURE]))) return $key;
                        } else {
                            if (is_null(filter_var($this->{$key}, FILTER_CALLBACK, ['options' => $condition, 'flags' => FILTER_NULL_ON_FAILURE]))) return $key;
                        }
                    }
                }
            } else if(is_array($condition)) {
                // If it's an array then it's a filter_var default condition with custom parameters like int min_range..
                $options = array(
                    'options' => $condition[1],
                    'flags' => FILTER_NULL_ON_FAILURE
                );
                if(is_null(filter_var($this->{$key}, (int)$condition[0], $options))) return $key;
            } else {
                Dbg::error("Unknown type of condition " . $condition);
            }
        }
        return true;
    }

    /**
     * Convert and return a Model list to a toArray list
     *
     * @param $objArray static[]
     * @return static[]
     */
    public static function listToArray(array $objArray) : array {
        $toReturn = [];
        foreach ($objArray as $item){
            $toReturn[] = $item->toArray();
        }
        return $toReturn;
    }

    /**
     * Return the DB fields of the object
     *
     * @return array
     */
    public static function getColumns(): array {
        return static::COLUMNS;
    }

}
