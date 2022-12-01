<?php

class CostModel 
{
    public $costRows;
    public $totalCost;

    public function getAllCosts()
    {
        include_once 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $obj = $dao->selectAllCosts();

        return ($obj) ? $obj : new CostModel();
    }

    public function saveCost($cost_value, $cost_reason, $cost_date, $user_id)
    {
        include 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $dao->insertCost($cost_value, $cost_reason, $cost_date, $user_id);

    }
}