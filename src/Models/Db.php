<?php

namespace Laura\P5\Models;

class Db {

    protected $db;

    public function __construct(){
        $url = parse_url(getenv("DATABASE_URL"));
        $server = $url["host"] ?? '127.0.0.1:8889';
        $username = $url["user"] ?? 'root';
        $password = $url["pass"] ?? 'root';
        $db = substr($url["path"], 1) ? substr($url["path"], 1) : 'pixy';
        //$db = 'pixy';
        try {
            $this->db = new \PDO("mysql:dbname={$db};host={$server}", $username, $password);
        } catch(\PDOException $e){
            echo("Erreur de connexion à la base de données: {$e->getMessage()}");
            die();
        }
    }


}
