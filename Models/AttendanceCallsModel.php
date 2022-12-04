<?php

class AttendanceCallsModel 
{
    public $attendanceRows;
    public $attendanceProfit;

    public function getAllAttendanceCalls()
    {
        include_once 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $obj = $dao->selectAllAttendanceCalls();

        return ($obj) ? $obj : new AttendanceCallsModel();
    }

    public function saveAttendanceCall($atendente, $data, $servico, $valor)
    {
        include 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $dao->insertAttendanceCall($atendente, $data, $servico, $valor);

    }

    public function delete(int $id)
    {
        include 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $obj = $dao->deleteAttendance($id);
    }
}