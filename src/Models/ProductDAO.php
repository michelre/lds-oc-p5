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

    }

    public function create($product){

    }

    public function update($product){

    }

    public function delete($id){

    }

}