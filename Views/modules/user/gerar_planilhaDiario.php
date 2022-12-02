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
        //CONSULTAS AO BANCO

        $dsn = "mysql:host=localhost;dbname=mydb";
        $conexao = new PDO($dsn, 'root', 'Deni@507050');

        //Tipo de atendimento
        $sql = "SELECT * FROM attendance";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        $resultadoAtendimento = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Chamadas de atendimentos
        $sql = "SELECT atc.attendance_calls_id, atc.attendance_id, atc.worker_id, atc.client_id, wk.worker_name, wk.worker_id, att.attendance_id, att.attendance_name, att.attendance_price, atc.attendance_date
                FROM attendance_calls atc
                INNER JOIN worker wk
                    ON wk.worker_id = atc.worker_id
                INNER JOIN attendance att
                    ON att.attendance_id = atc.attendance_id
                WHERE atc.attendance_date = $hoje
                ORDER BY atc.attendance_calls_id DESC";

        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        $resultadoChamadaAtendimento = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Custos
        $sql = "SELECT * FROM cost WHERE cost_date = $hoje";
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
                $html .= "<td colspan='4'> {$hoje} Relatorio Mensal de Custos</td>";
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
                            $html .= '<td>'.$custo['cost_value'].'</td>';
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

        //PARTE DE CHAMADO DE ATENDIMENTOS
                $html .= '<th>';
                    $html .= '<tr>';
                        $html .= '<td colspan="4">Atendimentos</td>';
                    $html .= '</tr>';
                $html .= '</th>';

                $html .= '<tr>';
                    $html .= '<td><b>Serviço</b></td>';
                    $html .= '<td><b>Atendente</b></td>';
                    $html .= '<td><b>Data</b></td>';
                    $html .= '<td><b>Valor</b></td>';
                    $html .= '<td><b>Lucro Total</b></td>';
                $html .= '</tr>';

                if(isset($resultadoChamadaAtendimento)){
                    foreach($resultadoChamadaAtendimento as $chamadoAtendimento){
                        $gain = $gain + $chamadoAtendimento['attendance_price'];
                        $totalGain = $gain;
                        $html .= '<tr>';
                            $html .= '<td>'.$chamadoAtendimento['attendance_name'].'</td>';
                            $html .= '<td>'.$chamadoAtendimento['worker_name'].'</td>';
                            $html .= '<td>'.$chamadoAtendimento['attendance_date'].'</td>';
                            $html .= '<td>'.$chamadoAtendimento['attendance_price'].'</td>';
                        $html .= '</tr>';
                    }
                    $html .= '<tr>';
                        $html .= '<td>'."".'</td>';
                        $html .= '<td>'."".'</td>';
                        $html .= '<td>'."".'</td>';
                        $html .= '<td>'."".'</td>';
                        if(isset($totalGain)){
                            $html .= '<td>'.'R$'.$totalGain.'</td>';
                        }
                    $html .= '</tr>';
                }
                
        $html .= '<br>';
        $html .= '<br>';

        //PARTE DOS LUCROS ATUAIS
                if(isset($totalGain) && isset($totalCost)){
                    $total = $totalGain-$totalCost;
                }
                $html .= '<th>';
                    $html .= '<tr>';
                        $html .= '<td colspan="4">Lucro Atual (Atendimentos - Custos Administrativos)</td>';
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
                            $html .= '<td>'.'R$-'.($total).'</td>';
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
                                $addGanho = $addGanho + $atendimento['attendance_price'];
                            }
                        }
                        $html .= '<tr>';
                            $html .= '<td>'.$trabalhador['worker_name'].'</td>';
                            $html .= '<td>'.'R$'.($addGanho).'</td>';
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