<?php

namespace ErasmusHelper\Core;

use Kreait\Firebase\Auth\UserRecord;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Contract\Database;
use Kreait\Firebase\Factory;

class DBConf {

    public Database $database;
    public Auth $auth;

    public function __construct() {
        $factory = (new Factory)
            ->withServiceAccount(APPLICATION_PATH . '/firebase_adminSDK.json')
            ->withDatabaseUri('https://erasmus-helper-default-rtdb.europe-west1.firebasedatabase.app/');
        $this->database = $factory->createDatabase();
        $this->auth = $factory->createAuth();
    }

    /**
     * Instantiates all the objects by datas.
     *
     * @param string $objClass Object class obtained by static::class
     * @param array $data Data for the object class to be instantiated
     * @return array
     */
    public static function instantiateAll(string $objClass, array $data): array {
        $toReturn = array();
        foreach ($data as $user) {
            $toReturn[] = new $objClass($user);
        }
        return $toReturn;
    }

    /**
     * Instantiates a single object by its data.
     *
     * @param string $objClass Object class obtained by static::class
     * @param array $array Data for the object class to be instantiated
     * @return mixed
     */
    public static function instantiate(string $objClass, array $array): mixed {
        return new $objClass($array);
    }

    /**
     * Instantiates a single object by its userRecord.
     *
     * @param string $objClass Object class obtained by static::class
     * @param UserRecord $data UserRecord associated to an Auth user
     * @return mixed
     */
    public static function instantiateAuth(string $objClass, UserRecord $data): mixed {
        return new $objClass($data);
    }
}