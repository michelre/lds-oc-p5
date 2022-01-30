<?php

namespace Laura\P5\Models;

class UserDAO extends Db {

    

    public function getOne($id){
        // Récupérer un seul produit avec son id
        $req = $this->db->query('SELECT * FROM user WHERE id = ' . $id);
        $req->setFetchMode(\PDO::FETCH_CLASS, 'Laura\P5\Models\User');
        return $req->fetch();

    }

    public function getByLogin($login){
        // Récupérer un seul produit avec son id
        $req = $this->db->query('SELECT * FROM user WHERE login = "' . $login . '"');
        $req->setFetchMode(\PDO::FETCH_CLASS, 'Laura\P5\Models\User');
        return $req->fetch();

    }

    

}