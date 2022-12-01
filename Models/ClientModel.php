<?php

class ClientModel 
{
    public $clientRows;

    public function getAllClients()
    {
        include_once 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $obj = $dao->selectAllClients();

        return ($obj) ? $obj : new ClientModel();
    }

    public function saveClient($client_name, $client_address, $client_phone)
    {
        include 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $dao->insertClient($client_name, $client_address, $client_phone);

    }
}