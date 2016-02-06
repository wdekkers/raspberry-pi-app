<?php

// Custom 404 Handler
$router->set404(function() {
  header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
  echo '404, route not found!';
});


/***************/
/* GPIO Routes */
/***************/
$router->mount('/gpio', function() use ($router) {

  // GPIO Write command :pin :value (0/1)
  $router->post('/write/(\S+)/(\S+)/','\Controllers\GPIOCtl::write');

  // GPIO Mode command :pin :value (IN or OUT)
  $router->post('/mode/(\S+)/(\S+)/','\Controllers\GPIOCtl::mode');
});

/***************/
/* RFID Routes */
/***************/
$router->mount('/rfid', function() use ($router) {

  // RFID send command :value 
  $router->post('/send/(\S+)/','\Controllers\RFIDCtl::send');
});