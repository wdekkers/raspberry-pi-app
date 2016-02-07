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

  public function list(){
    $list_gpio = new \Models\GPIO();

    echo json_encode($list_gpio->list());
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
