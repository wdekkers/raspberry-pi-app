<?php




/***************/
/* GPIO Routes */
/***************/
$router->mount('/gpio', function() use ($router) {

  // List ALL GPIO ports
  $router->get('/','\Controllers\GPIOCtl::read_all');

  // GPIO Write command :pin :value (0/1)
  $router->put('/write/(\S+)/(\S+)/','\Controllers\GPIOCtl::write');

  // GPIO Mode command :pin :value (IN or OUT)
  $router->put('/mode/(\S+)/(\S+)/','\Controllers\GPIOCtl::mode');
});

/***************/
/* RFID Routes */
/***************/
$router->mount('/rfid', function() use ($router) {

  // RFID send command :value 
  $router->put('/send/(\S+)/','\Controllers\RFIDCtl::send');
});

/*****************/
/* SWITCH Routes */
/*****************/
$router->mount('/switch', function() use ($router) {

  // Set the switch on / off
  $router->put('/set/(\S+)/(\S+)/','\Controllers\SwitchCtl::set');
});

/*****************/
/* SENSOR Routes */
/*****************/
$router->mount('/sensor', function() use ($router) {

  // Set the switch on / off
  $router->get('/temperature/(\S+)/','\Controllers\I2cCtl::get_temperature');
});


$router->options('/(\S+)','');

// Custom 404 Handler
$router->set404(function() {
  header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
  echo '404, route not found!';
});