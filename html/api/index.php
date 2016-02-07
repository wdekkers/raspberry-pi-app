<?php
// CORS when your origin is not localhost you are going to need this or else it will not work.
// if you are using it outside of your home network please reconsider the * of allow origin
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, PUT, DELETE, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, auth, user");
header("Access-Control-Max-Age: 1728000");

// Load the composer autoloader
require __DIR__ . '/../../vendor/autoload.php';

\Rhonda\Config:: load_file("config","../../etc/config.json");

\Rhonda\Config:: load_file("config","../../etc/config.json");
\Rhonda\Config:: load_file("config","../../etc/config.json");

\Rhonda\Config:: load_file("config","../../etc/config.json");
\Rhonda\Config:: load_file("config","../../etc/config.json");
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
