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
  * Write a pin status
  * <pre class="GET"> GET [url]/gpio/</pre>
  *
  * @param String - pin number
  * @param String - status
  *
  * @example
  * No POST Body
  *
  * @return JSON - **Array** of GPIO **Objects**
  *
  * @since   2016-02-05
  * @author  Wesley Dekkers <wesley@wd-media.nl>
  * @todo    check if statuss are set correctly
  * @todo    check if pin exists
  **/
  public function read_all(){
    $read_all = new \Models\GPIO();

    echo json_encode($read_all->read_all());
  }

  /**
  * Write a pin status
  * <pre class="PUT"> PUT [url]/gpio/write/:pin/:status/</pre>
  *
  * @param String - pin number
  * @param String - status
  *
  * @example
  * No POST Body
  *
  * @return JSON - **Object** success message
  *
  * @since   2016-02-05
  * @author  Wesley Dekkers <wesley@wd-media.nl>
  * @todo    check if statuss are set correctly
  * @todo    check if pin exists
  **/
  public function write($pin, $status){
    try{
      if(!is_numeric($pin) || !is_numeric($status)){
        throw new \Exception("Pin and Value should both be numeric", 1);
      }

      $write_gpio = new \Models\GPIO();
      $write_gpio->pin = $pin;
      $write_gpio->status = $status;

      $write_gpio->write();

      echo \Rhonda\Success:: create();
    }catch(\Exception $e){
      echo \Rhonda\Error:: handle($e);
    }
  }

  /**
  * Set a pin mode
  * <pre class="PUT"> PUT [url]/gpio/mode/:pin/:mode/</pre>
  *
  * @param String - pin number
  * @param String - mode IN/OUT (or others)
  *
  * @example
  * No POST Body
  *
  * @return JSON - **Object** success message
  *
  * @since   2016-02-05
  * @author  Wesley Dekkers <wesley@wd-media.nl>
  * @todo    check if modes are set correctly
  * @todo    check if pin exists
  **/
  public function mode($pin, $mode){
    try{
      if(!is_numeric($pin)){
        throw new \Exception("Pin should be numeric", 1);
      }

      $mode_gpio = new \Models\GPIO();
      $mode_gpio->pin = $pin;
      $mode_gpio->mode = $mode;

      $mode_gpio->mode();

      echo \Rhonda\Success:: create();
    }catch(\Exception $e){
      echo \Rhonda\Error:: handle($e);
    }
  }
}
