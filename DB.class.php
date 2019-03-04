<?php
/**
 * Database access class.
 * 
 * Class that wraps PDO and manages the database connection for the rest of the library.
 */
namespace DeeHants\Daeman;
class DB {
    private static $pdo = null;
    
    private static function connect() {
        if (self::$pdo) { return; }

        $config = Config::getKeyStatic("Database");
        $connect = "mysql:host=" . $config["Host"] . ";dbname=" . $config["Name"] . "";
        self::$pdo = new \PDO($connect, $config["Username"], $config["Password"]);
    }

    public static function query($query_string, array $parameters) {
        // Ensure we're connected
        self::connect();

        // Create the statement
        $statement = self::$pdo->prepare($query_string);
        if (isset($parameters)) { $statement->execute($parameters); }
        return $statement;
    }


    public static function queryRow($query_string, array $parameters) {
        // Run the query
        $statement = self::query($query_string, $parameters);

        // Extract the first row
        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        return $row;
    }

    public static function querySet($query_string, array $parameters) {
        // Run the query
        $statement = self::query($query_string, $parameters);

        // Extract all the rows
        $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $rows;
    }
}
