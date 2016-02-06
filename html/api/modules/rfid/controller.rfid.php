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
class RFIDCtl{

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
  public function send($id){
    try{
      $config = \Rhonda\Config::get('config');

      $send = new \Models\RFID();
      $send->id = $id;
      $send->path = $config->RFID_PATH;

      $send->send();

      echo \Rhonda\Success:: create();
    }catch(\Exception $e){
      echo \Rhonda\Error:: handle($e);
    }
  }

}
