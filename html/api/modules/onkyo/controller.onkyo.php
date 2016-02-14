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

    $config = new \stdClass();
    $config->command_code = '!xECN';
    $config->command_params = 'QSTN';
    $config->error_code = 0;

    $fp = \socket_create(AF_INET, SOCK_DGRAM, SOL_UDP); 
    \socket_set_option($fp, SOL_SOCKET, SO_BROADCAST, 1); 

    $command = $this->send_ISCP($fp, $config->command_code . $config->command_params);
    @fclose($fp);
    if($command) {
      $config->error_message = 'Success';
    }
    else {
      throw new \Exception("No receiver detected");
    }

    echo json_encode($config);
  }

  /**
  * send iscp command
  *
  * @param Resource - connection
  * @param 
  *
  * @example
  * <code>
  * Useage Example
  * </code>
  *
  * @return Return - **Object**
  *
  * @since   2016-01-01
  * @author  Wesley Dekkers <wesley@sdicg.com> 
  **/
  public function send_ISCP($fp, $request, $config) {
     try{
      $length = strlen($request) + 1;
      $command  = "ISCP\x00\x00\x00\x10\x00\x00\x00" . chr($length) . "\x01\x00\x00\x00" . $request . "\x0D";
      
      socket_sendto($fp, $command, $length + 16, 0, '255.255.255.255', 60128); 
      $from = '';
      $port = 0;
      $tries = 10;
      $status = false;
      while ($tries--) {
        $fRecv = socket_recvfrom($fp, $buff, 64, 0, $from, $port);
        if ($fRecv > 0) { $status = true; break; }
        sleep(1);
      }
      $reply_len = ord($buff[11]);
      $config->statusReply = substr($buff, 21, $reply_len);
      $info = explode('/', $config->statusReply);
      $config->modelName = $info[0];
      $config->modelIP = $from;
      $config->modelPort = $info[1];
      $config->model_country = $this->code_to_country($info[2]);
      $config->model_mac = join(':', str_split(substr($info[3], 0, 12), 2));
      $config->success = $status;

      return $config;
    }catch(\Exception $e){
      echo \Rhonda\Error:: handle($e);
    }
  }

  /**
  * Get the country of the receiver
  *
  * @param Parameter - String 
  *
  * @return Return - String
  *
  * @since   2016-02-13
  * @author  Wesley Dekkers <wesley@wd-media.nl> 
  **/
  public function code_to_country($code) {
    
    try{
      switch ($code) {
        case 'DX':
          return 'North America';
        case 'XX':
          return 'Europe/Asia';
        case 'JJ':
          return 'Japan';
        default:
          return 'Unknown';
      }
    }catch(\Exception $e){
      echo \Rhonda\Error:: handle($e);
    }
  }

}
