<?php

class SaleModel 
{
    public $saleRows;
    public $totalSale;

    public function getAllSales()
    {
        include_once 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $obj = $dao->selectAllSales();

        return ($obj) ? $obj : new SaleModel();
    }

    public function getMonthSales()
    {
        include_once 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $obj = $dao->selectMonthSales();

        return ($obj) ? $obj : new SaleModel();
    }

    public function saveSale($product_id, $sale_price, $client_id, $sale_date)
    {
        include 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $dao->insertSale($product_id, $sale_price, $client_id, $sale_date);

    }

    public function delete(int $id)
    {
        include 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $obj = $dao->deleteSale($id);
    }
}