<?php

namespace Laura\P5\Models;

class Db {

    protected $db;

    public function __construct(){
        $url = parse_url(getenv("DATABASE_URL"));

        $server = $url["host"];
        $username = $url["user"];
        $password = $url["pass"];
        $db = substr($url["path"], 1);
        $this->db = new \PDO("mysql:dbname={$db};host={$server}", $username, $password);
    }


}
