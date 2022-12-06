<?php

class UserController
{
    public static function pageLogin(){
        include 'Views/modules/user/FormLogin.php';
    }

    //Metodo generico para adicionar um registro no banco
    public static function add(){
        if(isset($_POST['atendimentoAction'])){

            include_once 'Models/AttendanceCallsModel.php';
            $cost = new AttendanceCallsModel();
            $cost->saveAttendanceCall($_POST['atendente'], $_POST['data'], $_POST['servico'], $_POST['cliente'], $_POST['desconto']);
            header("Location: /usuario/login");

        } else if(isset($_POST['custoAction'])){

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

        } else if(isset($_POST['tipo_servicoAction'])){

            include_once 'Models/AttendanceModel.php';
            $service = new AttendanceModel();
            $service->saveAttendance($_POST['nome'], $_POST['preco']);
            header("Location: /usuario/login");

        } else if(isset($_POST['clienteAction'])) {

            include_once 'Models/ClientModel.php';
            $cost = new ClientModel();
            $cost->saveClient($_POST['nome'], $_POST['endereco'], $_POST['celular']);
            header("Location: /usuario/login");

        } else if(isset($_POST['vendaAction'])){

            include_once 'Models/SaleModel.php';
            $sale = new SaleModel();
            $sale->saveSale($_POST['product'], $_POST['preco'], $_POST['cliente'], $_POST['data']);
            header("Location: /usuario/login");

        } else if(isset($_POST['tipo_produtoAction'])){

            include_once 'Models/ProductModel.php';
            $product = new ProductModel();
            $product->saveProduct($_POST['nome']);
            header("Location: /usuario/login");

        }
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
        include_once 'Models/SaleModel.php';
        include_once 'Models/ProductModel.php';

        $servicesModel = new ServicesModel();
        $attendanceModel = new AttendanceCallsModel();
        $clientModel = new ClientModel();
        $costModel = new CostModel();
        $workerModel = new WorkerModel();
        $attendanceSimpleModel = new AttendanceModel();
        $saleModel = new SaleModel();
        $productModel = new ProductModel();

        //Consulta os serviços disponiveis para aquele usuario do sistema!
        if(!empty($_SESSION['user_id'])){
            $objServices = $servicesModel->getAvaiableServicesByUserId($_SESSION['user_id']);
        } else {
            $objServices = $servicesModel->getAvaiableServicesByUserId($model->user_id);
        }

        $saleModel->totalSale = 0;
        $attendanceModel->attendanceProfit = 0;
        $costModel->totalCost = 0;
        $saleProfit = 0;

        //PEGANDO TODAS OS VENDAS
        $saleModel->saleRows = $saleModel->getAllSales();
        if(!empty($saleModel->saleRows)){
            foreach($saleModel->saleRows as $sale){
                $saleProfit = $saleProfit + $sale['sale_price'];
            }
            $saleModel->totalSale = $saleProfit;
        }
        
        //PEGANDO TODOS OS PRODUTOS
        $productModel->productRows = $productModel->getAllProducts();

        $cost = 0;

        //PEGANDO TODOS OS SERVIÇOS
        $attendanceModel->attendanceRows = $attendanceModel->getAllAttendanceCalls();
        if(!empty($attendanceModel->attendanceRows)){
            foreach($attendanceModel->attendanceRows as $register){
                if(!empty($register['attendance_discount'])){
    
                    $discount = $register['attendance_discount'] * $register['attendance_price'];
                    $realPrice = $register['attendance_price'] - $discount;
                    $cost = $cost + $realPrice;
                } else {
                    $cost = $cost + $register['attendance_price'];
                }
                $attendanceModel->attendanceProfit = $cost;
            }
        }
       
        //PEGANDO TODOS OS CLIENTES
        $clientModel->clientRows = $clientModel->getAllClients();

        $cost = 0;

        //PEGANDO TODOS OS CUSTOS ADMINISTRATIVOS
        $costModel->costRows = $costModel->getAllCosts();
        if(!empty($costModel->costRows)){
            foreach($costModel->costRows as $register){
                $cost = $cost + $register['cost_value'];
                $costModel->totalCost = $cost;
            }
        }

        //PEGANDO TODOS OS TRABALHADORES
        $workerModel->workerRows = $workerModel->getAllWorkers();
        $attendanceSimpleModel->attendanceRows = $attendanceSimpleModel->getAllAttendance();

        //CALCULANDO OS LUCROS DA EMPRESA
        $attendanceModel->attendanceProfit = $saleModel->totalSale + $attendanceModel->attendanceProfit - $costModel->totalCost;

        date_default_timezone_set('America/Sao_Paulo');
        $hoje = date('Y/m/d');
        $hoje = str_replace('/', "-", $hoje);
        
        //Inclui nossa view de dashboard.
        include_once 'Views/modules/user/Dashboard.php';
    }

    //Metodo generico para deletar algo do sistema
    public static function delete(){
        if($_GET['mode'] == 'atendimento'){

            include 'Models/AttendanceCallsModel.php';
            $model = new AttendanceCallsModel();

            $model->delete( (int) $_GET['id']);

            header("Location: /usuario/login");

        } else if($_GET['mode'] == 'clientes') {

            include 'Models/ClientModel.php';
            $model = new ClientModel();

            $model->delete( (int) $_GET['id']);
            header("Location: /usuario/login");

        } else {

            include 'Models/CostModel.php';
            $model = new CostModel();

            $model->delete( (int) $_GET['id']); 
            header("Location: /usuario/login");

        }
    }
    
}