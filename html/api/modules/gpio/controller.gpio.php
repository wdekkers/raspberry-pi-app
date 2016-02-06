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

      $write = new \Models\GPIO();
      $write->pin = $pin;
      $write->value = $value;

      $write->write();

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

      $mode = new \Models\GPIO();
      $mode->pin = $pin;
      $mode->value = $value;

      $mode->mode();

      echo \Rhonda\Success:: create();
    }catch(\Exception $e){
      echo \Rhonda\Error:: handle($e);
    }
  }
}
