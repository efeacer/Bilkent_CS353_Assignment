<?php
// Necessary import(s)
require 'config.php';

/**
* Implementation of the factory design pattern to create an
* appropriate mysqli object when needed.
* @author Efe Acer
* @version 1.0
*/
class ConnectionFactory {

    /**
    * Factory method to create a mysqli object, which is indeed a
    * MySQL Database connection.
    * @return $conn Newly created mysqli object
    */
    public static function getConnection() {
        // Establish MySQL connection
        $conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
        // Check for connection error
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }
        return $conn;
    }
}
?>
