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

  // Get temperature by sensor id
  $router->get('/temperature/(\S+)/','\Controllers\I2cCtl::get_temperature');

  // Get average temperature by sensor id's
  $router->post('/temperature/','\Controllers\I2cCtl::temperature_multiple');
});

/****************/
/* ONKYO Routes */
/****************/
$router->mount('/onkyo', function() use ($router) {

  // Get temperature by sensor id
  $router->get('/detect/','\Controllers\OnkyoCtl::detect');

  // Execute the command to the onkyo
  $router->PUT('/command/(\S+)/','\Controllers\OnkyoCtl::command');
});




$router->options('/(\S+)','');

// Custom 404 Handler
$router->set404(function() {
  header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
  echo '404, route not found!';
});