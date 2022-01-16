<?php

namespace Laura\P5\Services;

use \Mailjet\Resources;

class MailService {

    private $mj;

    public function __construct(){
        $env = parse_ini_file(__DIR__ . '/../../.env');
        $this->mj = new \Mailjet\Client($env['MJ_KEY'],$env['MJ_SECRET'],true,['version' => 'v3.1']);
    }
    
    public function sendMail($subject, $htmlPart){
        $body = [
            'Messages' => [
              [
                'From' => [
                  'Email' => "laumrsb@outlook.com",
                  'Name' => "Laura"
                ],
                'To' => [
                  [
                    'Email' => "laumrsb@outlook.com",
                    'Name' => "Laura"
                  ]
                ],
                'Subject' => $subject,
                'HTMLPart' => $htmlPart

              ]
            ]
          ];
          $response = $this->mj->post(Resources::$Email, ['body' => $body]);
          $response->success();
    }

}