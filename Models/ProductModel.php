<?php

class ProductModel 
{
    public $productRows;

    public function getAllProducts()
    {
        include_once 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $obj = $dao->selectAllProducts();

        return ($obj) ? $obj : new ProductModel();
    }

    public function saveProduct($product_name)
    {
        include 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $dao->insertProduct($product_name);

    }

    public function delete(int $id)
    {
        include 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $obj = $dao->deleteProduct($id);
    }
}