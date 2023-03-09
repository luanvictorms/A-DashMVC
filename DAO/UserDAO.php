<?php

class UserDAO
{
    public $conexao;

    public function __construct()
    {
        $dsn = "mysql:host=localhost;dbname=mydb";
        $this->conexao = new PDO($dsn, 'root', '');
        
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

        $sql = "SELECT atc.attendance_payment, atc.attendance_calls_id, atc.attendance_id, atc.worker_id, atc.client_id, wk.worker_name, wk.worker_id, att.attendance_id, att.attendance_name, att.attendance_price, atc.attendance_date, atc.attendance_discount, c.client_name
                FROM attendance_calls atc
                INNER JOIN worker wk
                    ON wk.worker_id = atc.worker_id
                INNER JOIN attendance att
                    ON att.attendance_id = atc.attendance_id
                INNER JOIN client c
                    ON c.client_id = atc.client_id
                ORDER BY atc.worker_id ASC";

        $stmt = $this->conexao->prepare($sql);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Seleciona todos as chamadas de atendimentos diarias
    public function selectTodayAttendanceCalls()
    {
        include_once 'Models/AttendanceCallsModel.php';
        date_default_timezone_set('America/Sao_Paulo');
        $hoje = date('Y/m/d');
        $hoje = str_replace('/', "-", $hoje);

        $sql = "SELECT atc.attendance_payment, atc.attendance_calls_id, atc.attendance_id, atc.worker_id, atc.client_id, wk.worker_name, wk.worker_id, att.attendance_id, att.attendance_name, att.attendance_price, atc.attendance_date, atc.attendance_discount, c.client_name
                FROM attendance_calls atc
                INNER JOIN worker wk
                    ON wk.worker_id = atc.worker_id
                INNER JOIN attendance att
                    ON att.attendance_id = atc.attendance_id
                INNER JOIN client c
                    ON c.client_id = atc.client_id
                WHERE atc.attendance_date = $hoje
                ORDER BY atc.worker_id ASC";

        $stmt = $this->conexao->prepare($sql);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Seleciona todos os Clientes
    public function selectAllClients()
    {
        include_once 'Models/ClientModel.php';

        $sql = "SELECT * FROM client";

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

    public function selectAllSales()
    {
        include_once 'Models/SaleModel.php';

        $sql = "SELECT * FROM sale";

        $stmt = $this->conexao->prepare($sql);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectAllProducts()
    {
        include_once 'Models/ProductModel.php';

        $sql = "SELECT * FROM product";

        $stmt = $this->conexao->prepare($sql);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectAllTickets()
    {
        include_once 'Models/ValeModel.php';

        $sql = "SELECT * FROM ticket";

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

    public function insertAttendanceCall($atendente, $data, $pagamento, $servico, $client, $desconto)
    {
        $sql = "INSERT INTO attendance_calls (attendance_id, worker_id, client_id, attendance_date, attendance_payment, attendance_discount) VALUES (?,?,?,?,?,?)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(1, $servico);
        $stmt->bindParam(2, $atendente);
        $stmt->bindParam(3, $client);
        $stmt->bindParam(4, $data);
        $stmt->bindParam(5, $pagamento);
        $stmt->bindParam(6, $desconto);

        $stmt->execute();
    }

    public function insertAttendance($nomeServiço, $preco)
    {
        $sql = "INSERT INTO attendance (attendance_name, attendance_price) VALUES (?,?)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(1, $nomeServiço);
        $stmt->bindParam(2, $preco);

        $stmt->execute();
    }

    //Inserindo uma nova venda
    public function insertSale($product_id, $sale_price, $client_id, $sale_date)
    {
        $sql = "INSERT INTO sale (product_id, sale_price, client_id, sale_date) VALUES (?,?,?,?)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(1, $product_id);
        $stmt->bindParam(2, $sale_price);
        $stmt->bindParam(3, $client_id);
        $stmt->bindParam(4, $sale_date);

        $stmt->execute();
    }

    //Insere um novo produto
    public function insertProduct($product_name)
    {
        $sql = "INSERT INTO product (product_name) VALUES (?)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(1, $product_name);

        $stmt->execute();
    }

    public function insertTicket($ticket_name, $ticket_reason, $ticket_value, $fk_worker_id, $fk_user_id, $ticket_date)
    {
        $sql = "INSERT INTO ticket (ticket_name, ticket_reason, ticket_value, fk_worker_id, fk_user_id, ticket_date) VALUES (?,?,?,?,?,?)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(1, $ticket_name);
        $stmt->bindParam(2, $ticket_reason);
        $stmt->bindParam(3, $ticket_value);
        $stmt->bindParam(4, $fk_worker_id);
        $stmt->bindParam(5, $fk_user_id);
        $stmt->bindParam(6, $ticket_date);

        $stmt->execute();
    }

    public function deleteAttendance(int $id)
    {
        $sql = "DELETE FROM attendance_calls WHERE attendance_calls_id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(1, $id);

        $stmt->execute();
    }

    public function deleteCost(int $id)
    {
        $sql = "DELETE FROM cost WHERE cost_id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(1, $id);

        $stmt->execute();
    }

    public function deleteClient(int $id)
    {
        $sql = "DELETE FROM client WHERE client_id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(1, $id);

        $stmt->execute();
    }

    public function deleteSale(int $id)
    {
        $sql = "DELETE FROM sale WHERE sale_id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(1, $id);

        $stmt->execute();
    }

    public function deleteTicket(int $id)
    {
        $sql = "DELETE FROM ticket WHERE ticket_id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(1, $id);

        $stmt->execute();
    }

    public function deleteProduct(int $id)
    {
        $sql = "DELETE FROM product WHERE product_id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(1, $id);

        $stmt->execute();
    }

}
