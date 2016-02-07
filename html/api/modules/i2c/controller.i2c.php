<?php

namespace Controllers;

/**
 * Controller to acomplish i2c sensor related tasks
 *
 * @category  Controller
 * @uses      \Rhonda\RequestBody
 * @version   0.0.1
 * @since     2016-02-07
 * @author    Wesley Dekkers <wesley@wd-media.nl>
*/
class I2cCtl{

  /**
  * Read a temperature value
  * <pre class="GET"> GET [url]/i2c/temperature/:id/</pre>
  *
  * @param String - id
  *
  * @example
  * No POST Body
  *
  * @return JSON - **Object** result info
  *
  * @since   2016-02-07
  * @author  Wesley Dekkers <wesley@wd-media.nl>
  * @todo    check if id exists
  **/
  public function get_temperature($id){
    try{
      $config = \Rhonda\Config::get('config');

      $sensor = new \Models\I2c();
      $sensor->id = $id;
      $sensor->path = $config->BUS_PATH;

      echo json_encode($sensor->get());
    }catch(\Exception $e){
      echo \Rhonda\Error:: handle($e);
    }
  }

}
