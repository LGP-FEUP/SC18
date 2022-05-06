<?php

namespace AgileBundle\Database;

use DateTime;
use PDO;
use PDOStatement;

/**
 * Class SQL
 * SQL Command generator
 *
 * @package AgileBundle\Database
 */
class SQL {

    /** @var ?PDO PDO instance */
    private static ?PDO $db;

    /**
     * Return the current instance of PDO or create the instance if not existing
     *
     * @return PDO
     */
    public static function db(): PDO {
        if(isset(self::$db)) return self::$db;
        $db = new PDO('mysql:host='.MYSQL_HOST.';port=3306;dbname='.MYSQL_DATABASE.';charset=utf8', MYSQL_USER, MYSQL_PASSWORD);
        if(is_dev()) $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        self::$db = $db;
        return $db;
    }

    /**
     * Execute a SELECT request to the database
     *
     * @param $tableName string
     * @param array|string $where Selection parameters, associative array or selection string ['foo' => 'bar'] means "WHERE 'foo' = 'bar'"
     * @param ?string $order
     * @param ?int $limit
     * @param ?int $offset
     * @param array $joinTables
     * @param bool $noGroupBy If set to true there will be no GROUP BY id at the end of the request
     * @param array|string $additionalSelect Other fields than $tableName.* (from the join for example) that must be selected
     * @return false|PDOStatement
     */
    public static function select(
        string $tableName,
        array|string $where = [],
        ?string $order = null,
        ?int $limit = null,
        ?int $offset = null,
        array $joinTables = [],
        bool $noGroupBy = false,
        array|string $additionalSelect = []
    ): bool|PDOStatement
    {
        // First we build the additionalSelect if it exists
        $additionalSelectStr = empty($additionalSelect) ? "" :
            (is_string($additionalSelect) ? $additionalSelect : implode(",", $additionalSelect));
        $req = "SELECT $tableName.* $additionalSelectStr FROM $tableName";

        // Then we build the joins (INNER JOIN for arrays)
        if(!empty($joinTables)){
            $joinClause = [];
            if(is_array($joinTables)) {
                foreach ($joinTables as $table => $params) {
                    $joinClause[] = "INNER JOIN $table ON $params[0] = $params[1]";
                }
                $req .= " " . implode(" ", $joinClause);
            } else {
                $req .= " " . $joinTables . " ";
            }
        }

        // Then we add the where clause
        if (!empty($where)) $req .= static::buildWhereClause($where);

        // Finally we build the end of the request with GROUP BY, ORDER BY, LIMIT and OFFSET clauses
        if(!$noGroupBy) $req .= " GROUP BY id ";
        if(!is_null($order)) $req.= " ORDER BY " . $order;
        if(!is_null($limit)) $req.= " LIMIT " . $limit;
        if(!is_null($offset)) $req.= " OFFSET " . $offset;

        return self::db()->query($req);
    }

    /**
     * Search for lines with columns matching "LIKE %query%"
     *
     * @param string $tableName
     * @param array $columns
     * @param string $query
     * @param ?string $order
     * @param ?int $limit
     * @param ?int $offset
     * @return false|PDOStatement
     */
    public static function search(
        string $tableName,
        array $columns,
        string $query,
        ?string $order = null,
        ?int $limit = null,
        ?int $offset = null
    ): bool|PDOStatement
    {
        // Initial request
        $req = "SELECT $tableName.* FROM $tableName";

        // We had all the columns with LIKE clauses searching for query parameter
        if(!empty($columns)){
            $whereClause = [];
            foreach ($columns as $column){
                $whereClause[] = $column ." LIKE '%".$query."%'";
            }
            $req .= " WHERE " . implode(" OR ", $whereClause);
        }

        // We finally add the ORDER BY, LIMIT and OFFSET clauses
        if(!is_null($order)) $req.= " ORDER BY " . $order;
        if(!is_null($limit)) $req.= " LIMIT " . $limit;
        if(!is_null($offset)) $req.= " OFFSET " . $offset;

        return self::db()->query($req);
    }

    /**
     * Insert an object into the database
     *
     * @param string $tableName
     * @param array|string $data Associative array or insert string
     * @return int The id of the inserted row
     */
    public static function insert(string $tableName, array|string $data): int {
        // Initial request
        $req = "INSERT INTO $tableName";

        // If data is an array we build the request with array elements
        if(is_array($data)) {
            $cols = [];
            $values = [];
            foreach ($data as $col => $value) {
                $cols[] = $col;
                $values[] = static::formatParameter($value);
            }
            $req .= " (" . implode(",", $cols) . ") VALUES(" . implode(",", $values) . ")";
        // Else we just parse data in the request
        } else if(is_string($data)){
            $req .= " $data";
        }

        self::db()->query($req);
        return (int)self::db()->lastInsertId();
    }

    /**
     * Supprime une ligne d'une table SQL
     * @param string $tableName Nom de la table
     * @param string|array $where conditions de suppressions
     * @return false|PDOStatement
     */
    public static function delete(string $tableName, string|array $where): bool|PDOStatement {
        // Initial request
        $req = "DELETE FROM $tableName";

        // We add the where clause
        if(!empty($where)) $req .= static::buildWhereClause($where);

        return self::db()->query($req);
    }

    /**
     * Update an existing line of the database
     *
     * @param string $tableName
     * @param array $data New data as associative array
     * @param array|string $where Update conditions
     * @return false|PDOStatement
     */
    public static function update(string $tableName, array $data, array|string $where): bool|PDOStatement {
        // Initial request
        $req = "UPDATE $tableName SET ";

        // We build the set clause
        $setClause = [];
        foreach ($data as $col => $value){
            $setClause[] = "$col = " . static::formatParameter($value);
        }
        $req .= implode(",", $setClause);

        // Then we build the where clause
        if (!empty($where)) $req .= static::buildWhereClause($where);

        return self::db()->query($req);
    }

    /**
     * Truncate a table from the database
     *
     * @param $tableName string
     * @return false|PDOStatement
     */
    public static function truncate(string $tableName): bool|PDOStatement {
        $req = "TRUNCATE $tableName";
        return self::db()->query($req);
    }

    /**
     * Convert an SQL result to a model
     *
     * @param $pdoStatement PDOStatement
     * @param $objectClass string Model class
     * @return Model
     */
    public static function instantiate(PDOStatement $pdoStatement, string $objectClass): Model {
        return new $objectClass($pdoStatement->fetch(PDO::FETCH_ASSOC));
    }

    /**
     * Convert an SQL result list to a model list
     *
     * @param $pdoStatement PDOStatement
     * @param $objectClass string Model class
     * @return Model[]
     */
    public static function instantiateAll(PDOStatement $pdoStatement, string $objectClass): array {
        $return = [];
        while($data = $pdoStatement->fetch(PDO::FETCH_ASSOC)){
            $return[] = new $objectClass($data);
        }
        return $return;
    }

    /**
     * Format the given parameter for SQL requests
     *
     * @param mixed $parameter
     * @return string
     */
    private static function formatParameter(mixed $parameter) : string {
        if(is_bool($parameter)) {
            return $parameter === true ? "1" : "0";
        } else if(is_numeric($parameter)) {
            return "$parameter";
        } else if($parameter instanceof DateTime){
            return $parameter->format('Y-m-d H:i:s');
        } else {
            return static::db()->quote($parameter);
        }
    }

    /**
     * Build a where clause depending on the given where data
     *
     * @param array|string $where
     * @important The resulting clause will start by WHERE
     * @return string Where clause starting by WHERE
     */
    private static function buildWhereClause(array|string $where) : string {
        if (!empty($where)) {
            // If where is an array we build the request depending on the array elements
            if (is_array($where)) {
                $whereClause = [];
                foreach ($where as $key => $value) {
                    $whereClause[] = "$key = " . static::formatParameter($value);
                }
                return " WHERE " . implode(" AND ", $whereClause);
            // Else we just parse the where parameter into the request
            } else {
                return " WHERE $where";
            }
        }
        return "";
    }

}
