<?php

namespace Movie;

use PDO;
use Support\Configuration\Configuration;

class DataAccess
{
    private static $pdo;

    public function __construct()
    {
        $this->initializePdo();
    }

    protected function initializePdo()
    {
        //Check if pdo is already initialized
        if(!empty(self::$pdo)){
            return;
        }

        //Laod database configuration
        $config = Configuration::getInstance();
        $databaseConfig = $config->getConfig()['database'];
        
        //Connect to database
        try{
        self::$pdo = new PDO(sprintf('mysql:host=%s;dbname=%s;charsrt=UTF8',
         $databaseConfig['host'],
         $databaseConfig['dbname']),
         $databaseConfig['username'],
         $databaseConfig['password'],
         [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"]
        );
        } catch(\PDOException $ex) {
            throw new \Exception(sprintf('Database connection failed.Error: %s', $ex->getMessage()));
        }
    }

    protected function execute($sql, $parameters)
    {
        //SQL Query prepare
        $statement = $this->getPdo()->prepare($sql);

        //Execute Query
       $status = $statement->execute($parameters);
       if(!$status){
           throw new \Exception($statement->errorInfo()[2]);
       }
       return $status;
    }

    protected function fetch($sql, $parameters = [], $typeOfReturn = PDO::FETCH_ASSOC)
    {
        //SQL Query prepare
        $statement = $this->getPdo()->prepare($sql);
                
        //Execute Query
        $status = $statement->execute($parameters);
        
        if(!$status){
           throw new \Exception($statement->errorInfo()[2]);
        }
        
        //Fetch
        return $statement->fetch($typeOfReturn);
    }

    protected function fetchAll($sql, $parameters = [], $typeOfReturn = PDO::FETCH_ASSOC)
    {
        //SQL Query prepare
        $statement = $this->getPdo()->prepare($sql);
        
        //Execute Query
        $status = $statement->execute($parameters);
        if(!$status){
            throw new \Exception($statement->errorInfo()[2]);
        }

        //Fetch all
        return $statement->fetchAll($typeOfReturn);
    }

    protected function getPdo()
    {
        return self::$pdo;
    }
}