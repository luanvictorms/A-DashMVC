<?php

class PessoaController
{
    public static function index()
    {
        include 'Models/PessoaModel.php';

        $model = new PessoaModel();
        $model->getAllRows();
        
        include 'Views/modules/pessoa/ListaPessoa.php';
    }

    public static function form()
    {
        include 'Models/PessoaModel.php';
        $model = new PessoaModel();

        if(isset($_GET['id'])){
            $model = $model->getById( (int) $_GET['id']);
        }

        include 'Views/modules/pessoa/FormPessoa.php';
    }

    public static function save()
    {
        include 'Models/PessoaModel.php';

        $model = new PessoaModel();

        $model->id = $_POST['id'];
        $model->nome = $_POST['nome'];
        $model->cpf = $_POST['cpf'];
        $model->data_nascimento = $_POST['data_nascimento'];

        $model->save();

        header("Location: /pessoa");
    }

    public static function delete()
    {
        include 'Models/PessoaModel.php';

        $model = new PessoaModel();

        $model->delete( (int) $_GET['id']); 

        header("Location: /pessoa");
    }
}