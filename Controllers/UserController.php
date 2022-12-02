<?php

class UserController
{
    public static function pageLogin(){
        include 'Views/modules/user/FormLogin.php';
    }

    public static function addCost(){
        include_once 'Models/CostModel.php';

        $cost = new CostModel();

        if(!empty($_SESSION['user_id'])){
            var_dump($_SESSION['user_id']);
            $cost->saveCost($_POST['custo'], $_POST['motivo'], $_POST['data'], $_SESSION['user_id']);
        } else if (!empty($model->user_id)){
            var_dump($model->user_id);
            $cost->saveCost($_POST['custo'], $_POST['motivo'], $_POST['data'], $model->user_id);
        } else {
            $cost->saveCost($_POST['custo'], $_POST['motivo'], $_POST['data'], 1);
        }
        
        header("Location: /usuario/login");
    }

    public static function addNewTypeAttendance(){
        include_once 'Models/AttendanceModel.php';

        $service = new AttendanceModel();

        $service->saveAttendance($_POST['nome'], $_POST['preco']);
        header("Location: /usuario/login");
    }

    public static function addAttendance(){
        include_once 'Models/AttendanceCallsModel.php';

        $cost = new AttendanceCallsModel();

        $cost->saveAttendanceCall($_POST['atendente'], $_POST['data'], $_POST['servico'], $_POST['cliente']);
        header("Location: /usuario/login");
    }

    public static function addClient(){
        include_once 'Models/ClientModel.php';

        $cost = new ClientModel();

        $cost->saveClient($_POST['nome'], $_POST['endereco'], $_POST['celular']);
        header("Location: /usuario/login");
    }

    public static function logar()
    {
        include_once 'Models/UserModel.php';
        
        $model = new UserModel();

        $model->user_name = $_POST['user_name'];
        $model->user_pass = $_POST['user_pass'];
        $obj = $model->getByUserAndPass( (string) $model->user_name, (string) $model->user_pass);

        if (!empty($obj->user_id)){
            //atribui a model o user id do objeto encontrado.
            $model->user_id = $obj->user_id;

            $_SESSION['user_id'] = $model->user_id;
            $_SESSION['user_name'] = $model->user_name;
            $_SESSION['user_pass'] = $model->user_pass;
        
            return $model;
        } else {
            session_destroy();
            global $msg;
            $msg = "Invalid data";
            header("Location: /");
        }
    }

    public static function logado($model){
        include_once 'Models/ServicesModel.php';
        include_once 'Models/AttendanceCallsModel.php';
        include_once 'Models/ClientModel.php';
        include_once 'Models/CostModel.php';
        include_once 'Models/WorkerModel.php';
        include_once 'Models/AttendanceModel.php';

        $servicesModel = new ServicesModel();
        $attendanceModel = new AttendanceCallsModel();
        $clientModel = new ClientModel();
        $costModel = new CostModel();
        $workerModel = new WorkerModel();
        $attendanceSimpleModel = new AttendanceModel();

        //Consulta os serviços disponiveis para aquele usuario do sistema!
        if(!empty($_SESSION['user_id'])){
            $objServices = $servicesModel->getAvaiableServicesByUserId($_SESSION['user_id']);
        } else {
            $objServices = $servicesModel->getAvaiableServicesByUserId($model->user_id);
        }
        
        $cost = 0;
        $attendanceModel->attendanceRows = $attendanceModel->getAllAttendanceCalls();
        foreach( $attendanceModel->attendanceRows as $register){
            $cost = $cost + $register['attendance_price'];
            $attendanceModel->attendanceProfit = $cost;
        }

        $clientModel->clientRows = $clientModel->getAllClients();

        $cost = 0;
        $costModel->costRows = $costModel->getAllCosts();
        foreach($costModel->costRows as $register){
            $cost = $cost + $register['cost_value'];
            $costModel->totalCost = $cost;
        }

        $workerModel->workerRows = $workerModel->getAllWorkers();
        $attendanceSimpleModel->attendanceRows = $attendanceSimpleModel->getAllAttendance();

        $attendanceModel->attendanceProfit = $attendanceModel->attendanceProfit - $costModel->totalCost;

        date_default_timezone_set('America/Sao_Paulo');
        $hoje = date('Y/m/d');
        $hoje = str_replace('/', "-", $hoje);
        
        //Inclui nossa view de dashboard.
        include_once 'Views/modules/user/Dashboard.php';
    }
    
}