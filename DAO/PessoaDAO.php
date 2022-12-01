<?php

class PessoaDAO
{
    public $conexao;

    public function __construct()
    {
        $dsn = "mysql:host=localhost;dbname=crud-mvc";


        $this->conexao = new PDO($dsn, 'root', '');
        
    }

    public function insert($cost_value, $cost_reason, $cost_date, $user_id)
    {
        $sql = "INSERT INTO cost (cost_value, cost_reason, cost_date, fk_user_id) VALUES (?,?,?,?)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(1, $cost_value);
        $stmt->bindParam(2, $cost_reason);
        $stmt->bindParam(3, $cost_date);
        $stmt->bindParam(4, $user_id);

        $stmt->execute();
    }

    public function update(PessoaModel $model)
    {
        $sql = "UPDATE pessoa SET nome = ?, cpf = ?, data_nascimento = ? WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(1, $model->nome);
        $stmt->bindParam(2, $model->cpf);
        $stmt->bindParam(3, $model->data_nascimento);
        $stmt->bindParam(4, $model->id);

        $stmt->execute();
    }

    public function select()
    {
        $sql = "SELECT * FROM pessoa";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function selectById(int $id)
    {
        include_once 'Models/PessoaModel.php';

        $sql = "SELECT * FROM pessoa WHERE id =?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(1, $id);

        $stmt->execute();

        return $stmt->fetchObject("PessoaModel");
    }
    

    public function delete(int $id)
    {
        $sql = "DELETE FROM pessoa WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(1, $id);

        $stmt->execute();
    }

}