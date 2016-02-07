<?php




/***************/
/* GPIO Routes */
/***************/
$router->mount('/gpio', function() use ($router) {

  // List ALL GPIO ports
  $router->get('/','\Controllers\GPIOCtl::list');

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


$router->options('/(\S+)','');

// Custom 404 Handler
$router->set404(function() {
  header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
  echo '404, route not found!';
});