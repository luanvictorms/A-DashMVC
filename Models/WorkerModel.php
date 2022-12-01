<?php

class WorkerModel 
{
    public $workerRows;

    public function getAllWorkers()
    {
        include_once 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $obj = $dao->selectAllWorkers();

        return ($obj) ? $obj : new WorkerModel();
    }
}