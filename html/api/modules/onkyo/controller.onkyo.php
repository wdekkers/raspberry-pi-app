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
class OnkyoCtl{
  /**
  * Detect onkyo, scan network to find receiver
  *
  * @return Return **Object**
  *
  * @since   2016-02-13
  * @author  Wesley Dekkers <wesley@wd-media.nl> 
  **/
  public function detect(){
    try{
      $config = new \stdClass();
      $config->code = '!xECN';
      $config->param = 'QSTN';
      $config->error_code = 0;

      $fp = \socket_create(AF_INET, SOCK_DGRAM, SOL_UDP); 
      \socket_set_option($fp, SOL_SOCKET, SO_BROADCAST, 1); 

      $onkyo = new \Models\Onkyo();

      $command = $onkyo->send($fp, $config);
      if($command) {
        $config->message = 'Success';
      }
      else {
        throw new \Exception("No receiver detected");
      }

      echo json_encode($command);
    }catch(\Exception $e){
      echo \Rhonda\Error:: handle($e);
    }
  }
/**
* Tell onkyo what setting to change
*
* @param String - What source type you wanna change PWR/MVL/AMT/SLI
*
* @example
* <code>
* {
*     param: "ID"
*   , ip: "ip address of device"
*   , port: "port of device"
* }
* </code>
*
* @return Return
*
* @since   2016-01-01
* @author  Wesley Dekkers <wesley@sdicg.com> 
**/
public function command($type){
  try{
    $body = \Rhonda\RequestBody::get();
    $body->type = $type;

    $onkyo = new \Models\Onkyo();

    /*
    $arrData = array(
    'cmdCode' => preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['cmd']),
    'cmdParam' => preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['param']),
    'ipAddress' => $_GET['ip'],
    'portNumber' => (int)$_GET['port'],
    'errCode' => 0,
    'errMessage' => '',
    );
    */
    error_log(print_r($body, true));
    $socket = 'tcp://'.$body->ip.':'.$body->port;
    error_log($socket);
    /*$fp = @stream_socket_client($socket, 0, '', 10);
    if(!$fp) {
      throw new \Exception("Failed to make a connection");
    }*/

    $fp = stream_socket_client($socket, $errno, $errstr, 30);
    if (!$fp) {
        echo "$errstr ($errno)<br />\n";
    }
    error_log('here maybe ?');
    
    if($body->type == 'MVL') {
      $body->param = min($body->param, 64);
      $body->param = str_pad($body->param, 2, '0', STR_PAD_LEFT);
    }
    $set = $onkyo->set($fp, $config);
    if(!$set){
      throw new \Exception("Failed to send request");
    }

    echo json_encode($set);
  }catch(\Exception $e){
    echo \Rhonda\Error:: handle($e);
  }
}



  

}
