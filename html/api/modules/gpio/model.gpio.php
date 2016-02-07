<?php

namespace Models;

/**
 * GPIO model to manipulate values on the raspberry pi board
 *
 * @category  Model
 * @version   0.0.1
 * @since     2016-02-05
 * @author    Wesley Dekkers <wesley@wd-media.nl>
*/
class GPIO{

  public $pin;
  public $value;

  function __construct($props=null) {
    if(isset($props)) {

      // check for required properties defined as public variables
      foreach (get_class_vars('\Models\GPIO') as $key => $value) {
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
  * Write a pin value to GPIO
  *
  * @since   2016-02-05
  * @author  Wesley Dekkers <wesley@wd-media.nl>
  **/
  public function list(){

    exec('gpio readall', $readall);

    return $readall;
  }

  /**
  * Write a pin value to GPIO
  *
  * @since   2016-02-05
  * @author  Wesley Dekkers <wesley@wd-media.nl>
  **/
  public function write(){
    error_log("gpio write {$this->pin} {$this->value}");
    system("gpio write {$this->pin} {$this->value}");

    # Future return check readall to see if change was executed correctly
  }

  /**
  * Set a mode for a pin on the GPIO
  *  
  * @since   2016-02-05
  * @author  Wesley Dekkers <wesley@wd-media.nl>
  **/
  public function mode(){
    error_log("gpio mode {$this->pin} {$this->value}");
    system("gpio mode {$this->pin} {$this->value}");

    # Future return check readall to see if change was executed correctly
  }

}