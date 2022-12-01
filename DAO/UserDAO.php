<?php

class UserDAO
{
    public $conexao;

    public function __construct()
    {
        $dsn = "mysql:host=localhost;dbname=mydb";
        $this->conexao = new PDO($dsn, 'root', 'Deni@507050');
        
    }

    public function selectById($userId)
    {
        include_once 'Models/UserModel.php';

        $sql = "SELECT * FROM users WHERE user_id =?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(1, $userId);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Seleciona o usuario apartir do nome de usuario e senha
    public function selectByUserAndPass(string $user_name, string $user_pass)
    {
        include_once 'Models/UserModel.php';

        $sql = "SELECT * FROM users WHERE user_name =? AND user_pass =?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(1, $user_name);
        $stmt->bindParam(2, $user_pass);

        $stmt->execute();

        return $stmt->fetchObject("UserModel");
    }

    //Seleciona todos os serviços disponiveis pelo ID do admin
    public function selectAvaiableServicesByUserId(int $user_id)
    {
        include_once 'Models/ServicesModel.php';

        $sql = "SELECT *
                FROM services
                INNER JOIN service ON service_id = services.service_service_id
                AND services.users_user_id =? ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(1, $user_id);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Seleciona todos os serviços ofertados
    public function selectAllAttendance()
    {
        include_once 'Models/AttendanceModel.php';

        $sql = "SELECT * FROM attendance";

        $stmt = $this->conexao->prepare($sql);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Seleciona todos as chamadas de atendimentos
    public function selectAllAttendanceCalls()
    {
        include_once 'Models/AttendanceCallsModel.php';

        $sql = "SELECT atc.attendance_calls_id, atc.attendance_id, atc.worker_id, atc.client_id, wk.worker_name, wk.worker_id, att.attendance_id, att.attendance_name, att.attendance_price, atc.attendance_date
                FROM attendance_calls atc
                INNER JOIN worker wk
                    ON wk.worker_id = atc.worker_id
                INNER JOIN attendance att
                    ON att.attendance_id = atc.attendance_id
                ORDER BY atc.attendance_calls_id DESC";

        $stmt = $this->conexao->prepare($sql);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Seleciona todos os Clientes
    public function selectAllClients()
    {
        include_once 'Models/ClientModel.php';

        $sql = "SELECT * FROM client ORDER BY client_id DESC";

        $stmt = $this->conexao->prepare($sql);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Seleciona todos os Custos no sistema
    public function selectAllCosts()
    {
        include_once 'Models/CostModel.php';

        $sql = "SELECT * FROM cost ORDER BY cost_date DESC";

        $stmt = $this->conexao->prepare($sql);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Seleciona todos os trabalhadores/Atendentes
    public function selectAllWorkers()
    {
        include_once 'Models/WorkerModel.php';

        $sql = "SELECT * FROM worker";

        $stmt = $this->conexao->prepare($sql);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertCost($cost_value, $cost_reason, $cost_date, $user_id)
    {
        $sql = "INSERT INTO cost (cost_value, cost_reason, cost_date, fk_user_id) VALUES (?,?,?,?)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(1, $cost_value);
        $stmt->bindParam(2, $cost_reason);
        $stmt->bindParam(3, $cost_date);
        $stmt->bindParam(4, $user_id);

        $stmt->execute();
    }

    public function insertClient($client_name, $client_address, $client_phone)
    {
        $sql = "INSERT INTO client (client_name, client_address, client_phone) VALUES (?,?,?)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(1, $client_name);
        $stmt->bindParam(2, $client_address);
        $stmt->bindParam(3, $client_phone);

        $stmt->execute();
    }

    public function insertAttendanceCall($atendente, $data, $servico, $valor)
    {
        $sql = "INSERT INTO attendance_calls (attendance_id, worker_id, client_id, attendance_date) VALUES (?,?,?,?)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(1, $servico);
        $stmt->bindParam(2, $atendente);
        $stmt->bindParam(3, $valor);
        $stmt->bindParam(4, $data);

        $stmt->execute();
    }

}