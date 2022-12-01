<?php

class ServicesModel 
{
    public $services_id;
    public $service_service_id;
    public $users_user_id;
    public $service_name;

    public function getAvaiableServicesByUserId(int $user_id)
    {
        include_once 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $obj = $dao->selectAvaiableServicesByUserId($user_id);

        return ($obj) ? $obj : new UserModel();
    }
}