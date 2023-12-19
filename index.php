<?php
// index.php

// Autoloading for dependencies
require __DIR__ . '/vendor/autoload.php';
// Autoloading for classes
spl_autoload_register(function ($class_name) {
    $class_name = str_replace("\\", DIRECTORY_SEPARATOR, $class_name);
    require __DIR__ . '/src/' . $class_name . '.php';

});

//load environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use Telefonbuch\config\Database;
use Telefonbuch\Controller\ContactController;

//init database
Database::init();


try {
    // create a new instance of controller
    $controller = new ContactController();

    $controller->showContactForms();
    // decide which method of controller to call based on request
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add') {
        $controller->addContact($_POST);
        $controller->showContacts();
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'search') {
        $controller->showContacts($_POST);
    } else {
        // default to showing the add person form
        $controller->showContacts();
    }
} catch (\Exception $e) {
    // if an error occurs, echo the message
    echo 'An error occurred: ' . $e->getMessage();
}


// printContacts
