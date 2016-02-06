<?php

// Load the composer autoloader
require __DIR__ . '/../../vendor/autoload.php';

\Rhonda\Config:: load_file("config","../../etc/config.json");


// Create Router instance
$router = new \Bramus\Router\Router();

// Define controllers
include 'modules/gpio/controller.gpio.php';
include 'modules/rfid/controller.rfid.php';

// Define models
include 'modules/gpio/model.gpio.php';
include 'modules/rfid/model.rfid.php';

// Define routes
require 'routes.php';

header('Content-Type: application/json');
// Run it!
$router->run();
