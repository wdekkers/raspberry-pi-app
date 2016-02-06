<?php

namespace Models;

/**
 * RFID model to manipulate values of RFID devices
 *
 * @category  Model
 * @version   0.0.1
 * @since     2016-02-05
 * @author    Wesley Dekkers <wesley@wd-media.nl>
*/
class RFID{

  public $pin;
  public $value;

  function __construct($props=null) {
    if(isset($props)) {

      // check for required properties defined as public variables
      foreach (get_class_vars('\Models\RFID') as $key => $value) {
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
  * Send out a RFID code/id
  *
  * @since   2016-02-05
  * @author  Wesley Dekkers <wesley@wd-media.nl>
  **/
  public function send(){

    shell_exec($this->path . $this->id);
    error_log("{$this->path} {$this->id}");

    # Unfortunatly RFID devices do not give feedback :(
  }

}