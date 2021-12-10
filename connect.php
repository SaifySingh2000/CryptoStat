<?php
/*
Saify
*/
    // Define the MySQL database connection to the database server with database credentials.
    define('DB_DSN', 'mysql:host=localhost;dbname=cryptocurrency');
    define('DB_USER', 'root');
    define('DB_PASS', '');

    try {
        // Create a new PDO connection to MySQL
        $database = new PDO(DB_DSN, DB_USER, DB_PASS);
    } catch (PDOException $e) {
        print "Error: " . $e->getMessage();
        die(); // Force execution to stop on errors.
    }
?>
