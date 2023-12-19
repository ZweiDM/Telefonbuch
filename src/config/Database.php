<?php
// config/Database.php


namespace Telefonbuch\config;

use PDO;
use PDOException;

class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;
    private string $host;
    private string $port;
    private string $dbName;
    private string $user;
    private string $password;
    private string $table;
    private string $dsn;


    private function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->port = $_ENV['DB_PORT'];
        $this->dbName = $_ENV['DB_NAME'];
        $this->user = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASSWORD'] ?? "";
        $this->table = $_ENV['DB_TABLE'];

        //create DSN (Data Source Name)
        $this->dsn = "mysql:host={$this->host};port={$this->port};charset=utf8";
        //create PDO instance
        $this->pdo = new PDO($this->dsn, $this->user, $this->password);
    }

    /**
     * @return PDO
     */
    public static function init(): PDO
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }

        $instance = self::$instance;
        $pdo = $instance->pdo;

        try {
            // Create the database if it does not exist
            $pdo->exec("CREATE DATABASE IF NOT EXISTS {$instance->dbName};");

            // Use the Database from $dbName and Create the table if it does not exist
            $pdo->exec("USE {$instance->dbName}; CREATE TABLE IF NOT EXISTS {$instance->table} (
            id INT NOT NULL AUTO_INCREMENT,
            firstName VARCHAR(100) NOT NULL,
            lastName VARCHAR(100) NOT NULL,
            phoneNumber VARCHAR(15) NOT NULL,
            PRIMARY KEY (id)
            );");
            // Set PDO options: enabled Exception Handling, Fetch Mode (Associative Array)
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            // echo "Database Connected...";

        } catch (PDOException $e) {
            // If there is an error with the connection, print the error message with the code
            echo "Connection failed (Code:" . $e->getCode() . "): " . $e->getMessage();
            //if ($e->getCode() === 1049) {
            //    echo "Please create the database and try again.";
            //}
        }

        return self::$instance->pdo;
    }

    /**
     * @return PDO
     */
    public static function getPDO(): PDO
    {
        if (self::$instance == null) {
            self::$instance = new Database();
            self::$instance->init();
        }

        return self::$instance->pdo;
    }

}

