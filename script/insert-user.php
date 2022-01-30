<?php

$db = new \PDO('mysql:dbname=pixy;host=127.0.0.1', 'root', '');
$req = $db->prepare('INSERT INTO user(login, password) VALUES(?, ?)');
        $req->execute([
            "admin",
            password_hash('admin123', PASSWORD_DEFAULT)
        ]);