<?php

namespace Laura\P5\Models;

class ProductDAO extends Db {

    public function getAll(){
        // Récupérer tous les produits
        $req = $this->db->query('SELECT * FROM product');
        return $req->fetchAll(\PDO::FETCH_CLASS, 'Laura\P5\Models\Product');
    }

    public function getOne($id){
        // Récupérer un seul produit avec son id
        $req = $this->db->query('SELECT * FROM product WHERE id = ' . $id);
        $req->setFetchMode(\PDO::FETCH_CLASS, 'Laura\P5\Models\Product');
        return $req->fetch();

    }

    public function create($product){

    }

    public function update($product){

    }

    public function delete($id){
        return $this->db->query('DELETE FROM product WHERE id = ' . $id);
    }

}