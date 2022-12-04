<?php
session_start();
include_once 'Controllers/MasterClass.php';

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch($url){
    case '/':
        session_destroy();
        UserController::pageLogin();
    break;

    case '/usuario/login':
        if(!empty($_SESSION['user_id'])){
            UserController::logado($_SESSION);
        } else {
            $model = UserController::logar();
            if(!empty($model)){
                UserController::logado($model);
            }
        }
    break;

    //Adicionar novo tipo de serviço
    case '/usuario/login/adicionarNovoTipoServico':
        UserController::addNewTypeAttendance();
    break;

    case '/usuario/login/adicionarCusto':
        UserController::addCost();
    break;

    case '/usuario/login/adicionarAtendimento':
        UserController::addAttendance();
    break;

    case '/usuario/login/adicionarCliente':
        UserController::addClient();
    break;

    case '/usuario/atendimento/delete':
        UserController::deleteAttendance();
    break;

    case '/usuario/custo/delete':
        UserController::deleteCost();
    break;

    case '/usuario/clientes/delete':
        UserController::deleteClient();
    break;

    

    /*
    case '/pessoa':
        PessoaController::index();
    break;

    case '/pessoa/form':
        PessoaController::form();
    break;

    case '/pessoa/form/save':
        PessoaController::save();
    break;

    case '/pessoa/delete':
        PessoaController::delete();
    break;
    */

    default:
        echo "Erro 404";
    break;

}