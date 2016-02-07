<?php

namespace Controllers;

/**
 * Controller to acomplish gpio related tasks
 *
 * @category  Controller
 * @uses      \Rhonda\RequestBody
 * @version   0.0.1
 * @since     2016-02-05
 * @author    Wesley Dekkers <wesley@wd-media.nl>
*/
class GPIOCtl{

  public function read_all(){
    $read_all = new \Models\GPIO();
    $read_all = $read_all->read_all;

    $all_gpio = array();
    foreach($read_all as $row){
      $row = explode("|", $row);
      // Because there could be two GPIO pins in two lines we check for two values
      // And we filter out the pins like ground and voltage
      if(is_numeric(trim($row[1]))){
        $pin = new \stdClass();
        $pin->pin = trim($row[1]);
        $pin->wiringpi_pin = trim($row[2]);
        $pin->name = trim($row[3]);
        $pin->mode = trim($row[4]);
        $pin->value = trim($row[5]);
        $pin->bord_number = trim($row[6]);

        $all_gpio[] = $pin;
      }

      if(is_numeric(trim($row[13]))){
        $pin = new \stdClass();
        $pin->pin = trim($row[13]);
        $pin->wiringpi_pin = trim($row[12]);
        $pin->name = trim($row[11]);
        $pin->mode = trim($row[10]);
        $pin->value = trim($row[9]);
        $pin->bord_number = trim($row[8]);

        $all_gpio[] = $pin;
      }
    }

    echo json_encode($all_gpio);
  }
  /**
  * Write a pin value
  * <pre class="POST"> GET [url]/gpio/write/:pin/:value/</pre>
  *
  * @param String - pin number
  * @param String - value
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
  public function write($pin, $value){
    try{
      if(!is_numeric($pin) || !is_numeric($value)){
        throw new \Exception("Pin and Value should both be numeric", 1);
      }

      $write_gpio = new \Models\GPIO();
      $write_gpio->pin = $pin;
      $write_gpio->value = $value;

      $write_gpio->write();

      echo \Rhonda\Success:: create();
    }catch(\Exception $e){
      echo \Rhonda\Error:: handle($e);
    }
  }

  /**
  * Set a pin mode
  * <pre class="POST"> GET [url]/gpio/mode/:pin/:value/</pre>
  *
  * @param String - pin number
  * @param String - value IN/OUT
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
  public function mode($pin, $value){
    try{
      if(!is_numeric($pin)){
        throw new \Exception("Pin should be numeric", 1);
      }

      $mode_gpio = new \Models\GPIO();
      $mode_gpio->pin = $pin;
      $mode_gpio->value = $value;

      $mode_gpio->mode();

      echo \Rhonda\Success:: create();
    }catch(\Exception $e){
      echo \Rhonda\Error:: handle($e);
    }
  }
}
