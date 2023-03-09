<?php
    $addAtendimento = 0;
    $addGanho = 0;
    date_default_timezone_set('America/Sao_Paulo');
    $hoje = date('Y/m/d');
    $hoje = str_replace('/', "-", $hoje);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A+Dashboard</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp"
      rel="stylesheet">
    <link rel="stylesheet" href="/Css/style2.css">
</head>
<body>
    <div class="container">
        <aside>
            <div class="top">
                <div class="logo">
                    <img src="/img/logomarca.png">
                    <h2>Jack<span class="danger">Phillips</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">close</span>
                </div>
            </div>

            <div class="sidebar">
                <a href="#" class="active">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Dashboard</h3>
                </a>
                <a href="">
                    <span class="material-icons-sharp">logout</span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>

        <!-- END OF ASIDE -->
        <main>
            <h1>Dashboard</h1>

            <div class="date">
                <input type="date" value="<?= $hoje ?>">
            </div>

            <div class="insights">
                <?php foreach($objServices as $obj): ?>
                    <?php if(in_array($obj['service_name'] == 'Administrador',$obj)): ?>
                        <div class="expanses">
                            <span class="material-icons-sharp">bar_chart</span>
                            <div class="middle">
                                <div class="left">
                                    <h3>
                                        <?php if($attendanceModel->attendanceProfit > 0){
                                            echo 'Lucro';
                                        } else {
                                            echo 'Prejuizo';
                                        }?>
                                    </h3>
                                    <h1>R$<?php echo $attendanceModel->attendanceProfit; ?></h1>
                                </div>
                            </div>

                            <small class="text-muted">Mês Atual</small>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                <!-- END OF EXPANSES -->
                <div class="sales">
                    <span class="material-icons-sharp">analytics</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Custos Administrativos</h3>
                            <?php foreach($objServices as $obj): ?>
                                <?php if(in_array($obj['service_name'] == 'Administrador',$obj)): ?>
                                    <h1>R$-<?php echo $costModel->totalCost; ?></h1>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <div class="progress">
                            <span class="material-icons-sharp number" >add</span>
                        </div>
                    </div>

                    <small class="text-muted">Mês Atual</small>
                </div>
                <!-- END OF SALES -->
                <div class="income">
                    <span class="material-icons-sharp">stacked_line_chart</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Vales</h3>
                            <?php foreach($objServices as $obj): ?>
                                <?php if(in_array($obj['service_name'] == 'Administrador',$obj)): ?>
                                    <?php if(!empty($valeModel->totalVale)): ?>
                                        <h1>R$-<?php echo $valeModel->totalVale; ?></h1>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <div class="progress">
                            <span class="material-icons-sharp number">add</span>
                        </div>
                    </div>

                    <small class="text-muted">Mês Atual</small>
                </div>
                <!-- END OF INCOME -->
                <div class="item add-product">
                    <div>
                        <span class="material-icons-sharp">add</span>
                        <h3>Realizar Atendimento</h3>
                    </div>
                </div>
                <div class="item add-product">
                    <div>
                        <span class="material-icons-sharp">add</span>
                        <h3>Cadastrar Novo Servico</h3>
                    </div>
                </div>
                <div class="item add-product">
                    <div>
                        <span class="material-icons-sharp">add</span>
                        <h3>Cadastrar Cliente</h3>
                    </div>
                </div>
                <div class="item add-product">
                    <div>
                        <span class="material-icons-sharp">add</span>
                        <h3>Cadastrar Produto</h3>
                    </div>
                </div>
            </div>
             <!-- END OF INSIGHTS -->

             <div class="recent-orders">
                <h2>Atendimentos Diario</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Serviço</th>
                                <th>Atendente</th>
                                <th>Cliente</th>
                                <th>Valor</th>
                                <th>Tipo Pgto</th>
                                <th>Data</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($attendanceModel->attendanceRows)): ?>
                                <?php foreach($attendanceModel->attendanceRows as $row): ?>
                                    <?php if($row['attendance_date'] == $hoje): ?>
                                        <tr>
                                            <td><?php echo $row['attendance_name']; ?></td>
                                            <td><?php echo $row['worker_name']; ?></td>
                                            <td><?php echo $row['client_name']; ?></td>
                                            <td>
                                                <?php 
                                                    $discount = $row['attendance_discount'] * $row['attendance_price']; 
                                                    $realPrice = $row['attendance_price'] - $discount;
                                                ?>
                                                <?php echo "R$" . "{$realPrice}"; ?>
                                            </td>
                                            <td><?php echo $row['attendance_payment'];?></td>
                                            <td><?php echo $row['attendance_date']; ?></td>
                                            <td><a style="text-decoration: none; text-align:center" href="/usuario/atendimento/delete?id=<?= $row['attendance_calls_id']?>&mode=atendimento"><span class="material-icons-sharp">delete</span></a></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <a href="" class="show-all">Mostrar Todos</a>
             </div>
        </main>
        <!-- END MAIN -->

        <div class="right">
            <div class="top">
                <button id="menu-btn">
                    <span class="material-icons-sharp">menu</span>
                </button>
                <div class="theme_toggler" id="theme_toggler">
                    <span class="material-icons-sharp active">light_mode</span>
                    <span class="material-icons-sharp">dark_mode</span>
                </div>
                <div class="profile">
                    <div class="info">
                        <p>Olá <b>Jack Philips</b></p>
                        <small class="text-muted">Admin</small>
                    </div>
                    <div class="profile-photo">
                        <img src="/img/profile-1.jpg">
                    </div>
                </div>
            </div>
            <!-- END TOP -->
            <div class="recent-updates">
                <h2>Novos Clientes</h2>
                <div class="updates">
                    <div class="update">
                        <?php $i = count($clientModel->clientRows);?>
                        <?php $menos2 = $i - 2; ?>
                        <?php foreach ($clientModel->clientRows as $row): ?>
                            <?php $i = $i - 1; ?>
                            <?php if($i >= $menos2): ?>
                                <div class="message">
                                    <p><b><?= $row['client_name'] ?></b></p>
                                    <small class="text-muted">Hoje</small>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <!-- END UPDATES -->
            <div class="sales-analytics">
                <h2>Insights</h2>
                <div class="item online">
                    <div class="icon">
                        <span class="material-icons-sharp active">groups</span>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>ATENDIMENTOS</h3>
                            <small class="text-muted">Mês Atual</small>
                        </div>
                        <h5 class="sucess">+39%</h5>
                        <h3>
                            <?php if(!empty($attendanceModel->attendanceRows)): ?>
                                <?php $ultimo = count($attendanceModel->attendanceRows);
                                echo $ultimo; ?>
                            <?php endif; ?>
                        </h3>
                    </div>
                </div>
                <div class="item offline">
                    <div class="icon">
                        <span class="material-icons-sharp">local_mall</span>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>PRODUTOS VENDIDOS</h3>
                            <small class="text-muted">Mês Atual</small>
                        </div>
                        <h5 class="danger">-12%</h5>
                        <h3>
                            <?php if(!empty($saleModel->saleRows)): ?>
                                <?php $ultimo = count($saleModel->saleRows);
                                echo $ultimo; ?>
                            <?php endif; ?>
                        </h3>
                    </div>
                </div>
                <div class="item customers">
                    <div class="icon">
                        <span class="material-icons-sharp">person</span>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>CLIENTES</h3>
                            <small class="text-muted">Ano Atual</small>
                        </div>
                        <h5 class="danger">+25%</h5>
                        <h3>
                            <?php if(!empty($clientModel->clientRows)): ?>
                                <?php $ultimo = count($clientModel->clientRows);
                                echo $ultimo; ?>
                            <?php endif; ?>
                        </h3>
                    </div>
                </div>
                <!-- Retirando os add e realocando
                <div class="item add-product">
                    <div>
                        <span class="material-icons-sharp">add</span>
                        <h3>Realizar Atendimento</h3>
                    </div>
                </div>
                <div class="item add-product">
                    <div>
                        <span class="material-icons-sharp">add</span>
                        <h3>Cadastrar Cliente</h3>
                    </div>
                </div>
                <div class="item add-product">
                    <div>
                        <span class="material-icons-sharp">add</span>
                        <h3>Cadastrar Produto</h3>
                    </div>
                </div>
                Fim da realização -->
            </div>
        </div>
    </div>
         
    <script src="/js/index.js"></script>
</body>
</html>