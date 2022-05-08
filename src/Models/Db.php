<?php

namespace Laura\P5\Models;

class Db {

    protected $db;

    public function __construct(){
        $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

        $server = $url["host"];
        $username = $url["user"];
        $password = $url["pass"];
        $db = substr($url["path"], 1);

        var_dump($server, $username, $password, $db);

        $this->db = new \PDO('mysql:dbname=pixy;host=127.0.0.1:8889', 'root', 'root');
    }


}
