<?php

namespace Laura\P5\Models;

class OrderDAO extends Db {

    public function getAll($offset, $limit){
        $req = $this->db->query('SELECT * FROM `order` LIMIT ' . $limit . ' OFFSET ' . $offset);
        return $req->fetchAll(\PDO::FETCH_CLASS, 'Laura\P5\Models\Order');
    }


    public function create($firstName, $lastName, $total, $uid){
        $req = $this->db->prepare('INSERT INTO `order`(first_name, last_name, total, uid) VALUES(?, ?, ?, ?)');
        $req->execute([
           $firstName, $lastName, $total, $uid
        ]);
    }

}