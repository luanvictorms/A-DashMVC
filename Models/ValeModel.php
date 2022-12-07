<?php

class ValeModel 
{
    public $valeRows;
    public $totalVale;

    public function getAllTickets()
    {
        include_once 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $obj = $dao->selectAllTickets();

        return ($obj) ? $obj : new ValeModel();
    }

    public function saveTicket($ticket_name, $ticket_reason, $ticket_value, $fk_worker_id, $fk_user_id, $ticket_date)
    {
        include 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $dao->insertTicket($ticket_name, $ticket_reason, $ticket_value, $fk_worker_id, $fk_user_id, $ticket_date);

    }

    public function delete(int $id)
    {
        include 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $obj = $dao->deleteTicket($id);
    }
}