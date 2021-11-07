<?php

namespace Laura\P5\Models;

class Db {

    protected $db;

    public function __construct(){
        $this->db = new \PDO('mysql:dbname=pixy;host=127.0.0.1', 'root', '');
    }


}