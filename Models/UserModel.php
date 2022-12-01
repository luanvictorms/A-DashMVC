<?php

class UserModel 
{
    public $user_id;
    public $user_name;
    public $user_pass;

    public function getById($userId){
        include_once 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $obj = $dao->selectById($userId);
        if($obj){
            return $obj;
        }
    }

    public function getByUserAndPass(string $user_name, string $user_pass)
    {
        include_once 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $obj = $dao->selectByUserAndPass($user_name, $user_pass);

        return ($obj) ? $obj : new UserModel();
    }
}