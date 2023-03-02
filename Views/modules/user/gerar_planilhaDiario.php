<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        date_default_timezone_set('America/Sao_Paulo');
        $hoje = date('Y/m/d');
        $hoje = str_replace('/', "-", $hoje);
        
        $cost = 0;
        $gain = 0;
        $addGanho = 0;
        $teste = 0;
        $totalGain = 0;
        $totalCost = 0;
        $totalVenda = 0;
        $totalTicketCost = 0;
        $valorTicket = 0;
        //CONSULTAS AO BANCO

        $dsn = "mysql:host=localhost;dbname=mydb";
        $conexao = new PDO($dsn, 'root', 'Deni@507050');

        //Tipo de atendimento
        $sql = "SELECT * FROM attendance";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        $resultadoAtendimento = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Pegando as despesas com vale
        $sql = "SELECT t.fk_worker_id, t.ticket_name, t.ticket_reason, t.ticket_value, t.ticket_date, w.worker_name, w.worker_id
        FROM ticket t
        INNER JOIN worker w
            ON t.fk_worker_id = w.worker_id
        WHERE t.ticket_date = '$hoje'
        ORDER BY t.ticket_date DESC";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        $resultadoTicket = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Resultado Vendas Produtos
        $sql = "SELECT s.sale_price, s.product_id, s.sale_date, p.product_id, p.product_name
        FROM sale s
        INNER JOIN product p
            ON p.product_id = s.product_id
        WHERE s.sale_date = '$hoje'
        ORDER BY s.product_id DESC";

        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        $resultadoVendasProdutos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Chamadas de atendimentos
        $sql = "SELECT atc.attendance_payment, atc.attendance_calls_id, atc.attendance_id, atc.worker_id, atc.client_id, wk.worker_name, wk.worker_id, att.attendance_id, att.attendance_name, att.attendance_price, atc.attendance_date, atc.attendance_discount, c.client_name
                FROM attendance_calls atc
                INNER JOIN worker wk
                    ON wk.worker_id = atc.worker_id
                INNER JOIN attendance att
                    ON att.attendance_id = atc.attendance_id
                INNER JOIN client c
                    ON c.client_id = atc.client_id
                WHERE atc.attendance_date = '$hoje'
                ORDER BY atc.attendance_calls_id DESC";

        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        $resultadoChamadaAtendimento = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Custos
        $sql = "SELECT * FROM cost WHERE cost_date = '$hoje'";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        $resultadoCustos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Trabalhadores
        $sql = "SELECT * FROM worker";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        $resultadoTrabalhadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //_________________________________________________________________________________________________________________________________________________________
        //Cabeçalho
        

        $arquivo = $hoje . "_relatorio_Diario.xls";
        $html = '';
        $html .= '<table border="1">';
        $html .= '<th>';
            $html .= '<tr>';
                $html .= "<td colspan='4'> {$hoje} Relatorio Diario de Custos</td>";
            $html .= '</tr>';
        $html .= '</th>';

        $html .= '<br>';
        $html .= '<br>';

        //PARTE DE CUSTOS
                $html .= '<th>';
                    $html .= '<tr>';
                        $html .= '<td colspan="4">Custos Administrativos</td>';
                    $html .= '</tr>';
                $html .= '</th>';

                $html .= '<tr>';
                    $html .= '<td><b>Motivo</b></td>';
                    $html .= '<td><b>Data de Retirada</b></td>';
                    $html .= '<td><b>Valor</b></td>';
                    $html .= '<td><b>Custo Total</b></td>';
                $html .= '</tr>';

                if(isset($resultadoCustos)){
                    //Somando os custos
                    foreach($resultadoCustos as $custo){
                        $cost = $cost + $custo['cost_value'];
                        $totalCost = $cost;
                    }

                    //Mostrando tudo o que tem da tabela de custos
                    foreach ($resultadoCustos as $custo){
                        $html .= '<tr>';
                            $html .= '<td>'.$custo['cost_reason'].'</td>';
                            $html .= '<td>'.$custo['cost_date'].'</td>';
                            $html .= '<td>'.'-R$'.$custo['cost_value'].'</td>';
                        $html .= '</tr>';
                    }
                    $html .= '<tr>';
                        $html .= '<td>'."".'</td>';
                        $html .= '<td>'."".'</td>';
                        $html .= '<td>'."".'</td>';
                        if(isset($totalCost)){
                            $html .= '<td>'.'-R$'.$totalCost.'</td>';
                        }
                        
                    $html .= '</tr>';
                }
            
        $html .= '<br>';
        $html .= '<br>';

        //PARTE DE VALES
                $html .= '<th>';
                $html .= '<tr>';
                    $html .= '<td colspan="4">Custos com Vales</td>';
                $html .= '</tr>';
                $html .= '</th>';

                $html .= '<tr>';
                    $html .= '<td><b>Nome Vale</b></td>';
                    $html .= '<td><b>Motivo</b></td>';
                    $html .= '<td><b>Nome Atendente</b></td>';
                    $html .= '<td><b>Data de Retirada</b></td>';
                    $html .= '<td><b>Valor Vale</b></td>';
                    $html .= '<td><b>Custo Total</b></td>';
                $html .= '</tr>';

                if(isset($resultadoTicket)){
                    //Somando os custos do ticket
                    foreach($resultadoTicket as $ticket){
                        $valorTicket = $valorTicket + $ticket['ticket_value'];
                        $totalTicketCost = $valorTicket;
                    }

                    //Mostrando tudo o que tem da tabela de vales
                    foreach ($resultadoTicket as $ticket){
                        $html .= '<tr>';
                            $html .= '<td>'.$ticket['ticket_name'].'</td>';
                            $html .= '<td>'.$ticket['ticket_reason'].'</td>';
                            $html .= '<td>'.$ticket['worker_name'].'</td>';
                            $html .= '<td>'.$ticket['ticket_date'].'</td>';
                            $html .= '<td>'.'-R$'.$ticket['ticket_value'].'</td>';
                        $html .= '</tr>';
                    }
                    $html .= '<tr>';
                        $html .= '<td>'."".'</td>';
                        $html .= '<td>'."".'</td>';
                        $html .= '<td>'."".'</td>';
                        $html .= '<td>'."".'</td>';
                        $html .= '<td>'."".'</td>';
                        $html .= '<td>'.'-R$'.$totalTicketCost.'</td>';
                        
                    $html .= '</tr>';
                }

        $html .= '<br>';
        $html .= '<br>';

        //PARTE DAS VENDAS DE PRODUTOS
        $html .= '<th>';
                    $html .= '<tr>';
                        $html .= '<td colspan="4">Vendas de Produtos</td>';
                    $html .= '</tr>';
                $html .= '</th>';

                $html .= '<tr>';
                    $html .= '<td><b>Produto</b></td>';
                    $html .= '<td><b>Preço do Produto</b></td>';
                    $html .= '<td><b>Data da Venda</b></td>';
                    $html .= '<td><b>Lucro Total</b></td>';
                $html .= '</tr>';

                if(isset($resultadoVendasProdutos)){
                    foreach($resultadoVendasProdutos as $vendas){
                        $teste = $teste + $vendas['sale_price'];
                        $totalVenda = $teste;
                    }

                    foreach ($resultadoVendasProdutos as $vendas){
                        $html .= '<tr>';
                            $html .= '<td>'.$vendas['product_name'].'</td>';
                            $html .= '<td>'.$vendas['sale_date'].'</td>';
                            $html .= '<td>'.$vendas['sale_price'].'</td>';
                        $html .= '</tr>';
                    }
                    $html .= '<tr>';
                        $html .= '<td>'."".'</td>';
                        $html .= '<td>'."".'</td>';
                        $html .= '<td>'."".'</td>';
                        $html .= '<td>'.'R$'.$totalVenda.'</td>';
                    $html .= '</tr>';
                }
                
        $html .= '<br>';
        $html .= '<br>';

        //PARTE DE CHAMADO DE ATENDIMENTOS
                $html .= '<th>';
                    $html .= '<tr>';
                        $html .= '<td colspan="4">Atendimentos</td>';
                    $html .= '</tr>';
                $html .= '</th>';

                $html .= '<tr>';
                    $html .= '<td><b>Serviço</b></td>';
                    $html .= '<td><b>Atendente</b></td>';
                    $html .= '<td><b>Cliente</b></td>';
                    $html .= '<td><b>Tipo Pgto</b></td>';
                    $html .= '<td><b>Data</b></td>';
                    $html .= '<td><b>Valor</b></td>';
                    $html .= '<td><b>Lucro Total</b></td>';
                $html .= '</tr>';

                if(isset($resultadoChamadaAtendimento)){
                    foreach($resultadoChamadaAtendimento as $chamadoAtendimento){

                        if(!empty($chamadoAtendimento['attendance_discount'])){
                            $discount = $chamadoAtendimento['attendance_discount'] * $chamadoAtendimento['attendance_price'];
                            $realPrice = $chamadoAtendimento['attendance_price'] - $discount;
                            $gain = $gain + $realPrice;
                        } else {
                            $gain = $gain + $chamadoAtendimento['attendance_price'];
                        }

                        $totalGain = $gain;
                        $html .= '<tr>';
                            $html .= '<td>'.$chamadoAtendimento['attendance_name'].'</td>';
                            $html .= '<td>'.$chamadoAtendimento['worker_name'].'</td>';
                            $html .= '<td>'.$chamadoAtendimento['client_name'].'</td>';
                            $html .= '<td>'.$chamadoAtendimento['attendance_payment'].'</td>';
                            $html .= '<td>'.$chamadoAtendimento['attendance_date'].'</td>';
                            if(!empty($realPrice)){
                                $html .= '<td>'.$realPrice.'</td>';
                            } else {
                                $html .= '<td>'.$chamadoAtendimento['attendance_price'].'</td>';
                            }
                        $html .= '</tr>';
                        $realPrice = 0;
                    }
                    $html .= '<tr>';
                        $html .= '<td>'."".'</td>';
                        $html .= '<td>'."".'</td>';
                        $html .= '<td>'."".'</td>';
                        $html .= '<td>'."".'</td>';
                        $html .= '<td>'."".'</td>';
                        $html .= '<td>'."".'</td>';
                        $html .= '<td>'.'R$'.$totalGain.'</td>';
                    $html .= '</tr>';
                }
                
        $html .= '<br>';
        $html .= '<br>';

        //PARTE DOS LUCROS ATUAIS

                $total = $totalVenda + $totalGain - $totalTicketCost - $totalCost;

                $html .= '<th>';
                    $html .= '<tr>';
                        $html .= '<td colspan="4">Lucro Atual (Atendimentos + Vendas - Custos Administrativos)</td>';
                    $html .= '</tr>';
                $html .= '</th>';

                $html .= '<tr>';
                    $html .= '<td><b>Lucro Total da Empresa</b></td>';
                $html .= '</tr>';

                $html .= '<tr>';
                    if(isset($total)){
                        if($total > 0){
                            $html .= '<td>'.'R$'.($total).'</td>';
                        } else {
                            $html .= '<td>'.'-R$'.($total).'</td>';
                        }
                    }
                $html .= '</tr>';

        $html .= '<br>';
        $html .= '<br>';

        //PARTE DOS VALORES REFERENTES AOS TRABALHADORES
                $html .= '<th>';
                $html .= '<tr>';
                    $html .= '<td colspan="4">Valor Ganho por Trabalhador</td>';
                $html .= '</tr>';
                $html .= '</th>';

                $html .= '<tr>';
                    $html .= '<td><b>Nome</b></td>';
                    $html .= '<td><b>Valor</b></td>';
                $html .= '</tr>';

                if(isset($resultadoTrabalhadores)){
                    foreach ($resultadoTrabalhadores as $trabalhador){
                        $addGanho = 0;
                        foreach($resultadoChamadaAtendimento as $atendimento){
                            if($atendimento['worker_id'] == $trabalhador['worker_id']){
                                if(!empty($atendimento['attendance_discount'])){
                                    $discount = $atendimento['attendance_discount'] * $atendimento['attendance_price'];
                                    $realPrice = $atendimento['attendance_price'] - $discount;
                                    $addGanho = $addGanho + $realPrice;
                                } else {
                                    $addGanho = $addGanho + $atendimento['attendance_price'];
                                }
                            }
                        }
                        $html .= '<tr>';
                            $html .= '<td>'.$trabalhador['worker_name'].'</td>';
                            if($trabalhador['worker_name'] == 'Vitor'){
                                $addGanho = $addGanho * 0.43;
                                $html .= '<td>'.'R$'.($addGanho).'</td>';
                            } else {
                                $html .= '<td>'.'R$'.($addGanho).'</td>';
                            }
                        $html .= '</tr>';
                    }
                }

        header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header ("Last-Modified:" . gmdate("D,d M YH:i:s") . " GMT");
        header ("Cache-Control: no-cache, must-revalidade");
        header ("Pragma: no-cache");
        header ("Content-type: application/x-msexcel");
        header ("Content-Disposition: attachment; filename=\"{$arquivo}\"");
        header ("Content-Description: PHP Generated Data");
        echo $html;
        exit;
    ?>
</body>
</html>