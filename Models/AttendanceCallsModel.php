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

    public function getTodayAttendanceCalls()
    {
        include_once 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $obj = $dao->selectTodayAttendanceCalls();

        return ($obj) ? $obj : new AttendanceCallsModel();
    }

    public function getMonthAttendanceCalls()
    {
        include_once 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $obj = $dao->selectMonthAttendanceCalls();

        return ($obj) ? $obj : new AttendanceCallsModel();
    }

    public function saveAttendanceCall($atendente, $data, $pagamento, $servico, $cliente, $desconto)
    {
        include 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $dao->insertAttendanceCall($atendente, $data, $pagamento, $servico, $cliente, $desconto);

    }

    public function delete(int $id)
    {
        include 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $obj = $dao->deleteAttendance($id);
    }
}