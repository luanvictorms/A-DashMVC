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
        UserController::add();
    break;

    case '/usuario/logout/':
        session_destroy();
        UserController::pageLogin();
    break;

    case '/usuario/login/adicionarCusto':
        UserController::add();
    break;

    case '/usuario/login/adicionarAtendimento':
        UserController::add();
    break;

    case '/usuario/login/adicionarCliente':
        UserController::add();
    break;

    case '/usuario/login/adicionarVenda':
        UserController::add();
    break;

    case '/usuario/login/adicionarVale':
        UserController::add();
    break;

    case '/usuario/login/adicionarNovoProduto':
        UserController::add();
    break;

    //Deletar registros
    case '/usuario/atendimento/delete':
        UserController::delete();
    break;

    case '/usuario/custo/delete':
        UserController::delete();
    break;

    case '/usuario/clientes/delete':
        UserController::delete();
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