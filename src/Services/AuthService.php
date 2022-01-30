<?php

namespace Laura\P5\Services;

use \Mailjet\Resources;

class AuthService {

    public static function checkAuthentication(){
      if(!isset($_SESSION['user_id'])){
        header('Location: /P5/login');
        die();
      }
    }

}