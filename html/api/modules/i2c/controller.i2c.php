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

      echo json_encode($sensor->get_temperature());
    }catch(\Exception $e){
      echo \Rhonda\Error:: handle($e);
    }
  }

  /**
  * Read average temperature value of multiple sensors
  * <pre class="POST"> POST [url]/i2c/temperature/</pre>
  *
  * @example
  * [
  *     "sensor_id"
  *   , "sensor_id"
  * ]
  *
  * @return JSON - **Object** result info
  *
  * @since   2016-02-07
  * @author  Wesley Dekkers <wesley@wd-media.nl>
  * @todo    check if id exists
  **/
  public function temperature_multiple(){
    try{
      $config = \Rhonda\Config::get('config');

      // Load post body
      $body = \Rhonda\RequestBody:: get();

      $celcius = 0;
      $fahrenheit = 0;
      $count = count($body);
      error_log($count);

      foreach($body as $sensor){
        $sensor = new \Models\I2c();
        error_log(print_r($sensor,true));
        $sensor->id = $sensor[0];
        $sensor->path = $config->BUS_PATH;

        $temp = $sensor->get_temperature();
        error_log("eacht temp ".$celcius);
        $celcius = $celcius + $temp->celcius;
        $fahrenheit = $fahrenheit + $temp->fahrenheit;
      }

      $average = new \stdClass();
      $average->celcius = $celcius / $count;
      $average->fahrenheit = $fahrenheit / $count;


      echo json_encode($average);
    }catch(\Exception $e){
      echo \Rhonda\Error:: handle($e);
    }
  }

}
