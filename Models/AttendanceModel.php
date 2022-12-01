<?php

class AttendanceModel 
{
    public $attendanceRows;

    public function getAllAttendance()
    {
        include_once 'DAO/UserDAO.php';

        $dao = new UserDAO();

        $obj = $dao->selectAllAttendance();

        return ($obj) ? $obj : new AttendanceModel();
    }
}