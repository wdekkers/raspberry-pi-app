<?php

namespace Controllers;

/**
 * Controller to switch power on relay on/off
 *
 * @category  Controller
 * @uses      \Rhonda\RequestBody
 * @version   0.0.1
 * @since     2016-02-07
 * @author    Wesley Dekkers <wesley@wd-media.nl>
*/
class SwitchCtl{

  public function get(){
    $get = new \Models\GPIO();

    echo json_encode($read_all->read_all());
  }
  /**
  * Switch pin ON / OFF
  * <pre class="PUT"> PUT [url]/switch/set/:pin/:value/</pre>
  *
  * @param String - pin number
  * @param String - value (ON/OFF)
  *
  * @example
  * No POST Body
  *
  * @return JSON - **Object** success message
  *
  * @since   2016-02-05
  * @author  Wesley Dekkers <wesley@wd-media.nl>
  * @todo    check if values are set correctly
  * @todo    check if pin exists
  **/
  public function set($pin, $value){
    try{
      if(!is_numeric($pin)){
        throw new \Exception("Pin should be numeric");
      }

      # Load the model
      $set_gpio = new \Models\GPIO();
      $set_gpio->pin = $pin;

      # Decide what to do
      if($value == 'ON'){
        $set_gpio->status = 1;
        $set_gpio->mode = 'OUT';
      }
      elseif($value == 'OFF'){
        $set_gpio->status = 0;
        $set_gpio->mode = 'IN';
      }
      else{
        throw new \Exception("No valid pin value entered");
      }
      
      // Execute the commands
      $set_gpio->write();
      $set_gpio->mode();

      // Reload the pin
      echo json_encode($set_gpio->get());
    }catch(\Exception $e){
      echo \Rhonda\Error:: handle($e);
    }
  }

}
