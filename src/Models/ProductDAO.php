<?php

namespace Laura\P5\Models;

class ProductDAO extends Db {

    public function getAll($offset, $limit){
        // Récupérer tous les produits
        $req = $this->db->query('SELECT * FROM product LIMIT ' . $limit . ' OFFSET ' . $offset);
        return $req->fetchAll(\PDO::FETCH_CLASS, 'Laura\P5\Models\Product');
    }

    public function getTotal(){
        // Récupérer tous les produits
        $req = $this->db->query('SELECT count(*) as total FROM product');
        return intval($req->fetch()['total']);
    }

    public function getOne($id){
        // Récupérer un seul produit avec son id
        $req = $this->db->query('SELECT * FROM product WHERE id = ' . $id);
        $req->setFetchMode(\PDO::FETCH_CLASS, 'Laura\P5\Models\Product');
        return $req->fetch();

    }

    public function create($title, $description, $image, $price, $shortDescription){
        $req = $this->db->prepare('INSERT INTO product(title, description, image, price, shortDescription) VALUES(?, ?, ?, ?, ?)');
        $req->execute([
            $title, $description, $image, $price, $shortDescription
        ]);
    }

    public function update($id, $title, $description, $image, $price, $shortDescription){
        $req = $this->db->prepare('UPDATE product SET title=?, description=?, image=?, price=?, short_description=? WHERE id=?');
        $req->execute([
            $title, $description, $image, $price, $shortDescription, $id
        ]);
    }

    public function delete($id){
        return $this->db->query('DELETE FROM product WHERE id = ' . $id);
    }

}