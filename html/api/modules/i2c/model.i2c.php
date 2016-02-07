<?php

namespace Models;

/**
 * i2c model to retrieve data
 *
 * @category  Model
 * @version   0.0.1
 * @since     2016-02-07
 * @author    Wesley Dekkers <wesley@wd-media.nl>
*/
class I2c{

  public $id;
  public $path;

  function __construct($props=null) {
    if(isset($props)) {

      // check for required properties defined as public variables
      foreach (get_class_vars('\Models\I2c') as $key => $value) {
        if( !property_exists($props, $key) ){
          // throw an error if one of the required properties is not set
          throw new \Exception("required parameter $key absent", 1);
        }
      }

      // set the model object value to that of the incoming post body
      foreach ($props as $key => $value) {
        $this->$key = $value;
      }
    }

    return $this;
  }

  /**
  * retrieve data from sensor by id
  *
  * @since   2016-02-07
  * @author  Wesley Dekkers <wesley@wd-media.nl>
  **/
  public function get_temperature(){

    $sensor = new \stdClass();

    // Load the data out of the sensor
    error_log("cat ".$this->path."".$this->id."/w1_slave");
    exec("cat ".$this->path."".$this->id."/w1_slave", $temp);
    error_log(print_r($temp,true));
    $sensor_info = explode('t=', $temp);
    error_log(print_r($sensor_info,true));
    $sensor->celsius = $sensor_info[1]/1000;
    $sensor->fahrenheit = $this->celcius_to_fahrenheit($sensor->celsius);

    return $sensor;
  }

  public function celcius_to_fahrenheit($celcius){
    return ($celcius*(9/5)+32);
  }

}