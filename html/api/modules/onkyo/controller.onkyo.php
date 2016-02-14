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

    $onkyo = new \Models\Onkyo();

    $config = $onkyo->send_ISCP($fp, $config->command_code . $config->command_params);
    @fclose($fp);
    if($command) {
      $config->message = 'Success';
    }
    else {
      throw new \Exception("No receiver detected");
    }

    echo json_encode($config);
  }

  

}
