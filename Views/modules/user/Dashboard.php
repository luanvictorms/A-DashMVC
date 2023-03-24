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
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp"
      rel="stylesheet">
    <link rel="stylesheet" href="/Css/style2.css">
</head>
<body>
    <div class="container-main">

        <aside>
            <div class="top">
                <div class="logo">
                    <img src="/img/logomarca.png">
                    <h2>Jack<span class="jack">Phillips</span></h2>
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
                <a href="logout/">
                    <span class="material-icons-sharp">logout</span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>

        <!--MODAIS-->
            <dialog id="modal-atendimento">
                <form action="/usuario/login/adicionarAtendimento" method="POST">

                    <div style="margin-top: 15%; padding-left: 20%; padding-right: 20%">
                        <h1>Realizar Atendimento</h1>
                        <input type="hidden" name="atendimentoAction">

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01">Atendente</label>
                            <select class="form-select" id="inputGroupSelect01" name="atendente" required>
                                <?php foreach($workerModel->workerRows as $obj): ?>    
                                    <option value="<?php echo $obj['worker_id'] ?>"><?php echo $obj['worker_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect10">Tipo Pgto</label>
                            <select class="form-select" id="inputGroupSelect10" name="pagamento" required>
                                    <option value="PIX">PIX</option>
                                    <option value="DINHEIRO">DINHEIRO</option>
                                    <option value="DEBITO">Cartão de Debito</option>
                                    <option value="CREDITO">Cartão de Credito</option>
                            </select>
                        </div>
                        
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect04">Data Atendimento</label>
                            <input type="date" id="inputGroupSelect04" class="form-control" name="data" value="<?php echo $hoje;?>" required>
                        </div>

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02">Serviço</label>
                            <input type="search" id="texto" class="input-group-text" list="inputGroupSelect02" name="servico" required>
                            <datalist id="inputGroupSelect02">
                                
                                <?php foreach($attendanceSimpleModel->attendanceRows as $obj): ?>
                                    <option value="<?php echo $obj['attendance_id'] ?>"><?php echo $obj['attendance_name'] ?></option>
                                <?php endforeach; ?>

                            </datalist>
                        </div>

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect05">Desconto</label>
                            <select class="form-select" id="inputGroupSelect05" name="desconto" required>
                                <option value="0">Sem Desconto</option>    
                                <option value="0.05">5%</option>
                                <option value="0.1">10%</option>
                                <option value="0.15">15%</option>
                                <option value="0.20">20%</option>
                            </select>
                        </div>

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect03">Cliente</label>
                            <input type="search" id="texto" class="input-group-text" list="inputGroupSelect03" name="cliente" required>
                            <datalist id="inputGroupSelect03">

                                <?php foreach($clientModel->clientRows as $obj): ?>
                                    <option value="<?php echo $obj['client_id'] ?>"><?php echo $obj['client_name'] ?></option>
                                <?php endforeach; ?>

                            </datalist>
                        </div>

                        <input type="submit" class="btn btn-dark" value="Salvar Atendimento">
                    </div>
                
                </form>
            </dialog>

            <dialog id="modal-novo-servico">
                <form action="/usuario/login/adicionarNovoTipoServico" method="POST">
                    <div style="margin-top: 20%; padding-left: 20%; padding-right: 20%">
                        <h1>Cadastrar novo Serviço</h1>
                        <input type="hidden" name="tipo_servicoAction">

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01">Nome do Serviço</label>
                            <input type="text" id="inputGroupSelect01" class="form-control" name="nome" required>
                        </div>

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01">Preço do Serviço: R$</label>
                            <input type="double" id="inputGroupSelect01" class="form-control" name="preco" required>
                        </div>
                        
                        <input type="submit" class="btn btn-dark" value="Adicionar Novo Serviço">
                    </div>
                    
                </form>
            </dialog>

            <dialog id="modal-cliente">
                <form action="/usuario/login/adicionarCliente" method="POST">

                    <div style="margin-top: 20%; padding-left: 20%; padding-right: 20%">
                        <h1>Cadastrar novo Cliente</h1>
                        <input type="hidden" name="clienteAction">

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01">Nome</label>
                            <input type="text" id="inputGroupSelect01" class="form-control" name="nome" required>
                        </div>

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02">Endereço</label>
                            <input type="text" id="inputGroupSelect02" class="form-control" name="endereco">
                        </div>

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect03">Celular</label>
                            <input type="text" id="inputGroupSelect03" class="form-control" name="celular">
                        </div>

                        <input type="submit" class="btn btn-dark" value="Adicionar Cliente">
                    </div>

                </form>
            </dialog>

            <dialog id="modal-produto">
                <form action="/usuario/login/adicionarNovoProduto" method="POST">
                    <div style="margin-top: 20%; padding-left: 20%; padding-right: 20%">
                        <h1>Cadastrar novo Produto</h1>
                        <input type="hidden" name="tipo_produtoAction">

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01">Nome do Produto</label>
                            <input type="text" id="inputGroupSelect01" class="form-control" name="nome" required>
                        </div>

                        <input type="submit" class="btn btn-dark" value="Adicionar Novo Produto">
                    </div>
                
                </form>
            </dialog>

            <dialog id="modal-produto-venda">
                <form action="/usuario/login/adicionarVenda" method="POST">
                    <div style="margin-top: 20%; padding-left: 20%; padding-right: 20%">
                        <h1>Realizar venda de produto</h1>
                        <input type="hidden" name="vendaAction">

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect20">Produto</label>
                            <input type="search" id="texto" class="input-group-text" list="inputGroupSelect20" name="product" required>

                            <datalist id="inputGroupSelect20">
                                <?php foreach($productModel->productRows as $product): ?>    
                                    <option value="<?php echo $product['product_id'] ?>"><?php echo $product['product_name'] ?></option>
                                <?php endforeach; ?>
                            </datalist>

                        </div>

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect03">Preço</label>
                            <input type="double" id="inputGroupSelect03" class="form-control" name="preco">
                        </div>

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect21">Cliente</label>
                            <input type="search" id="texto" class="input-group-text" list="inputGroupSelect21" name="cliente" required>

                            <datalist id="inputGroupSelect21">
                                <?php foreach($clientModel->clientRows as $obj): ?>
                                    <option value="<?php echo $obj['client_id'] ?>"><?php echo $obj['client_name'] ?></option>
                                <?php endforeach; ?>
                            </datalist>

                        </div>

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect04">Data da Compra</label>
                            <input type="date" id="inputGroupSelect04" class="form-control" name="data" value="<?php echo $hoje;?>" required>
                        </div>

                        <input type="submit" class="btn btn-dark" value="Efetuar Venda">
                    </div>
                </form>
            </dialog>

            <dialog id="modal-custo">
                <form action="/usuario/login/adicionarCusto" method="POST">
                    <div style="margin-top: 20%; padding-left: 20%; padding-right: 20%">
                        <h1>Registrar Custo Administrativo</h1>
                        <input type="hidden" name="custoAction">

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect26">Motivo de custo</label>
                            <input type="text" id="inputGroupSelect26" class="form-control" name="motivo" required>
                        </div>

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect25">Data Atendimento</label>
                            <input type="date" id="inputGroupSelect25" class="form-control" name="data" value="<?php echo $hoje;?>" required>
                        </div>

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect27">Custo</label>
                            <input type="double" id="inputGroupSelect27" class="form-control" name="custo" required>
                        </div>

                        <input type="submit" class="btn btn-dark" value="Adicionar Custo">
                    </div>
                </form>
            </dialog>

            <dialog id="modal-vale">
                <form action="/usuario/login/adicionarVale" method="POST">
                    <div style="margin-top: 15%; padding-left: 20%; padding-right: 20%">
                        <h1>Registrar utilização de Vale</h1>
                        <input type="hidden" name="valeAction">

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01">Nome Vale</label>
                            <input type="text" id="inputGroupSelect01" class="form-control" name="name" required>
                        </div>

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02">Motivo</label>
                            <input type="text" id="inputGroupSelect02" class="form-control" name="reason">
                        </div>

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect22">Vale Para</label>
                            <select class="form-select" id="inputGroupSelect22" name="atendente" required>
                                <?php foreach($workerModel->workerRows as $obj): ?>    
                                    <option value="<?php echo $obj['worker_id'] ?>"><?php echo $obj['worker_name'] ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect05">Valor</label>
                            <input type="double" id="inputGroupSelect05" class="form-control" name="value" required>
                        </div>

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect04">Data do Vale</label>
                            <input type="date" id="inputGroupSelect04" class="form-control" name="date" value="<?php echo $hoje;?>" required>
                        </div>

                        <input type="submit" class="btn btn-dark" value="Adicionar Vale">
                    </div>
                </form>
            </dialog>
        <!--END MODAIS-->

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
                                            echo 'Lucro em Caixa';
                                        } else {
                                            echo 'Prejuizo em Caixa';
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
                <?php foreach($objServices as $obj): ?>
                    <?php if(in_array($obj['service_name'] == 'Administrador',$obj)): ?>
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
                            </div>

                            <small class="text-muted">Mês Atual</small>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                <!-- END OF SALES -->
                <?php foreach($objServices as $obj): ?>
                    <?php if(in_array($obj['service_name'] == 'Administrador',$obj)): ?>
                        <div class="income">
                            <span class="material-icons-sharp">stacked_line_chart</span>
                            <div class="middle">
                                <div class="left">
                                    <h3>Vales</h3>
                                    <?php foreach($objServices as $obj): ?>
                                        <?php if(in_array($obj['service_name'] == 'Administrador',$obj)): ?>
                                            <?php if($valeModel->totalVale > 0): ?>
                                                <h1>R$-<?php echo $valeModel->totalVale; ?></h1>
                                            <?php else: ?>
                                                <h1>R$-<?php echo 0; ?></h1>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <small class="text-muted">Mês Atual</small>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                <!-- END OF INCOME -->
                
                <!--NEW ADD METHOD-->
                <div class="item add-product cadastro">
                    <div>
                        <button id="modal-button-cliente"><span id="cadastro" class="material-icons-sharp">face</span></button>
                        <h3>Cadastrar Cliente</h3>
                    </div>
                </div>
                <div class="item add-product cadastro">
                    <div>
                        <button id="modal-button-novo-servico"><span id="cadastro" class="material-icons-sharp">home_repair_service</span></button>
                        <h3>Cadastrar Novo Servico</h3>
                    </div>
                </div>
                <div class="item add-product cadastro">
                    <div>
                        <button id="modal-button-produto"><span id="cadastro" class="material-icons-sharp">science</span></button>
                        <h3>Cadastrar Produto</h3>
                    </div>
                </div>
                <div class="item add-product realizar">
                    <div>
                        <button id="modal-button-atendimento"><span id="realizar" class="material-icons-sharp">work</span></button>
                        <h3>Realizar Atendimento</h3>
                    </div>
                </div>
                <div class="item add-product realizar">
                    <div>
                        <button id="modal-button-produto-venda"><span id="realizar" class="material-icons-sharp">sell</span></button>
                        <h3>Realizar Venda de Produto</h3>
                    </div>
                </div>
                <div style="visibility:hidden;" class="item add-product">
                    <div>
                        <h3></h3>
                    </div>
                </div>
                <div class="item add-product registrar">
                    <div>
                        <button id="modal-button-custo"><span id="registrar" class="material-icons-sharp">credit_card</span></button>
                        <h3>Registrar Custo Administrativo</h3>
                    </div>
                </div>
                <div class="item add-product registrar">
                    <div>
                        <button id="modal-button-vale"><span id="registrar" class="material-icons-sharp">confirmation_number</span></button>
                        <h3>Registrar Uso de Vale</h3>
                    </div>
                </div>
            </div>
            <!-- END OF INSIGHTS -->
            <hr>
            <?php foreach($workerModel->workerRows as $obj):?>
                <div class="recent-orders">
                    <h2>Atendimentos Diario - <?php echo $obj['worker_name']?></h2>
                    <table>
                        <thead>
                            <tr>
                                <th><span class="material-icons-sharp">work</span><p>Serviço</p></th>
                                <th><span class="material-icons-sharp">perm_contact_calendar</span><p>Barbeiro</p></th>
                                <th><span class="material-icons-sharp">face</span><p>Cliente</p></th>
                                <th><span class="material-icons-sharp">attach_money</span><p>Valor</p></th>
                                <th><span class="material-icons-sharp">credit_score</span><p>Tipo de Pagamento</p></th>
                                <th><span class="material-icons-sharp">calendar_month</span><p>Data Atendimento</p></th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(is_array($attendanceModel->attendanceRows)): ?>
                                <?php foreach($attendanceModel->attendanceRows as $row): ?>
                                    <?php if($row['worker_name'] == $obj['worker_name']):?>
                                        <?php if($row['attendance_date'] == $hoje): ?>
                                            <?php if($row['worker_name'] == 'Diego Jack'):?>
                                                <?php foreach($objServices as $service):?>
                                                    <?php if(in_array($service['service_name'] == 'Administrador',$obj)):?>
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
                                            <?php else: ?>
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
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <!--<a href="" class="show-all">Mostrar Todos</a>-->
                </div>
                <hr>
            <?php endforeach; ?>
            <div class="recent-orders">
                <h2>Uso de Vale Diario</h2>
                <table>
                    <thead>
                        <tr>
                            <th class="dark-table"><span class="material-icons-sharp">confirmation_number</span><p>Ticket</p></th>
                            <th class="dark-table"><span class="material-icons-sharp">psychology</span><p>Motivo</p></th>
                            <th class="dark-table"><span class="material-icons-sharp">attach_money</span><p>Valor</p></th>
                            <th class="dark-table"><span class="material-icons-sharp">perm_contact_calendar</span><p>Barbeiro</p></th>
                            <th class="dark-table"><span class="material-icons-sharp">calendar_month</span><p>Data Atendimento</p></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($valeModel->valeRows)): ?>
                            <?php foreach($valeModel->valeRows as $row): ?>
                                <?php if($hoje <= $row['ticket_date']): ?>
                                    <tr>
                                        <td>
                                            <?php echo $row['ticket_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['ticket_reason']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['ticket_value']; ?>
                                        </td>
                                        <td>
                                            <?php foreach($workerModel->workerRows as $worker){
                                                if($worker['worker_id'] == $row['fk_worker_id']){
                                                    echo $worker['worker_name'];
                                                }
                                            } 
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $row['ticket_date']; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="recent-orders">
                <h2>Custos Administrativos Diario</h2>
                <table>
                    <thead>
                        <tr>
                            <th class="dark-table"><span class="material-icons-sharp">attach_money</span><p>Valor</p></th>
                            <th class="dark-table"><span class="material-icons-sharp">psychology</span><p>Motivo</p></h>
                            <th class="dark-table"><span class="material-icons-sharp">calendar_month</span><p>Data Atendimento</p></th>
                            <th class="dark-table"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($costModel->costRows)): ?>
                            <?php foreach($costModel->costRows as $row): ?>
                                <?php if($row['cost_date'] == $hoje):?>
                                    <tr>
                                        <td>
                                            <?php echo "R$" . "{$row['cost_value']}"; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['cost_reason']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['cost_date']; ?>
                                        </td>
                                        <td>
                                            <a style="text-decoration: none;  text-align:center" href="/usuario/custo/delete?id=<?= $row['cost_id']?>&mode=custo"><span class="material-icons-sharp">delete</span></a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="recent-orders" id="final">
                <h2>Colaboradores</h2>
                <table>
                    <thead>
                        <tr>
                            <th class="dark-table"><span class="material-icons-sharp">perm_contact_calendar</span><p>Barbeiro</p></th>
                            <th class="dark-table"><span class="material-icons-sharp">request_quote</span><p>Valor Ganho</p></h>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($workerModel->workerRows as $obj): ?>
                            <tr>
                                <td>
                                    <?php echo $obj['worker_name']; ?>
                                </td>
                                <td>
                                    <?php if(is_array($attendanceModel->attendanceRows)):?>
                                        <?php foreach($attendanceModel->attendanceRows as $attendanceCall): ?>
                                            <?php if($attendanceCall['attendance_date'] == $hoje): ?>
                                                <?php if($attendanceCall['worker_id'] == $obj['worker_id']){
                                                    if(!empty($attendanceCall['attendance_discount'])){
                                                        $discount = $attendanceCall['attendance_discount'] * $attendanceCall['attendance_price'];
                                                        $realPrice = $attendanceCall['attendance_price'] - $discount;
                                                        $addGanho = $addGanho + $realPrice;
                                                    } else {
                                                        $addGanho = $addGanho + $attendanceCall['attendance_price'];
                                                        $arrayGanho[] = ['ganho' => $addGanho, 'nome' => $obj['worker_name'], 'id' => $obj['worker_id']];
                                                    }
                                                }  
                                                ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                    <?php if($obj['worker_name'] == 'Vitin'): ?>
                                        <?php $addGanho = $addGanho * 0.429; ?>
                                        <?php echo "R$" . "$addGanho"; ?>
                                    <?php elseif ($obj['worker_name'] == 'Kesley'): ?>
                                        <?php $addGanho = $addGanho * 0.429; ?>
                                        <?php echo "R$" . "$addGanho"; ?>
                                    <?php elseif($obj['worker_name'] == 'Sem_nome'): ?>
                                        <?php $addGanho = $addGanho * 0.429; ?>
                                        <?php echo "R$" . "$addGanho"; ?>
                                    <?php else: ?>
                                        <?php foreach($objServices as $obj): ?>
                                            <?php if(in_array($obj['service_name'] == 'Administrador',$obj)): ?>
                                                <?php echo "R$" . "$addGanho"; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php $addGanho = 0; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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
                        <p>Olá 
                            <b>
                                <?php if(!empty($_SESSION)) {echo $_SESSION['user_name'];} else {echo $model->user_name;}?>
                            </b>
                        </p>
                        <?php foreach($objServices as $obj): ?>
                            <?php if(in_array($obj['service_name'] == 'Administrador',$obj)): ?>
                                <small class="text-muted">Super Admin</small>
                            <?php endif; ?>
                            <?php if($obj['service_name'] == 'Simple') :?>
                                <small class="text-muted">Usuario</small>
                            <?php endif; ?>
                        <?php endforeach; ?>
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
            <hr>
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
                            <?php if(is_array($attendanceModel->attendanceRows)): ?>
                                <?php $ultimo = count($attendanceModel->attendanceRows);
                                echo $ultimo; ?>
                            <?php else: ?>
                                <?php echo 0;?>
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
                            <?php if($saleModel->totalSale > 0): ?>
                                <?php $ultimo = count($saleModel->saleRows);
                                echo $ultimo; ?>
                            <?php else: ?>
                                <?php echo 0; ?>
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
                        <h5 class="sucess">+25%</h5>
                        <h3>
                            <?php if($clientModel->clientRows > 0): ?>
                                <?php $ultimo = count($clientModel->clientRows);
                                echo $ultimo; ?>
                            <?php else: ?>
                                <?php echo 0;?>
                            <?php endif; ?>
                        </h3>
                    </div>
                </div>
                <div class="item customers">
                    <div class="icon">
                        <span class="material-icons-sharp">groups</span>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>QNT. ATENDIMENTOS</h3>
                            <small class="text-muted">Ano Atual</small>
                        </div>
                        <div>
                            <input style="width:90px;" type="search" id="texto" class="input-group-text" list="inputGroupSelect32" name="clients">
                            <datalist id="inputGroupSelect32">
                                <?php if(is_array($clientModel->clientRows)):?>
                                    <?php foreach($clientModel->clientRows as $rowClientes): ?>
                                        <option value="<?php echo $rowClientes['client_name'] ?>">
                                            
                                            <?php if(is_array($attendanceModel->attendanceRows)):?>
                                                <?php foreach($attendanceModel->attendanceRows as $attendanceCall): ?>
                                                    <?php if($attendanceCall['client_id'] == $rowClientes['client_id']): ?>
                                                        <?php $addAtendimento = ($addAtendimento + 1); ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php echo $addAtendimento ?>
                                            <?php else: ?>
                                                <?php echo 0 ?>
                                            <?php endif; ?>

                                            <?php if($rowClientes['client_phone']):?>
                                                <?php echo $rowClientes['client_phone']?>
                                            <?php else:?>
                                                <?php echo "nulo" ?>
                                            <?php endif; ?>

                                            <?php if($rowClientes['client_address']):?>
                                                <?php echo $rowClientes['client_address']?>
                                            <?php else:?>
                                                <?php echo "nulo" ?>
                                            <?php endif; ?>

                                        </option>
                                        <?php $addAtendimento = 0; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </datalist>
                        </div>
                    </div>
                </div>


                <?php foreach($objServices as $obj):?>
                    <?php if(in_array($obj['service_name'] == 'Administrador',$obj)):?>
                        <hr>
                        <h2>Relatorios</h2>
                        <div class="item offline">
                            <div class="icon">
                                <span class="material-icons-sharp">description</span>
                            </div>
                            <div class="right">
                                <div class="info">
                                    <div>
                                        <label class="btn btn-dark"><a href='/Views/modules/user/gerar_planilhaDiario.php' style="text-decoration: none;">Diario</a></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item offline">
                            <div class="icon">
                                <span class="material-icons-sharp">description</span>
                            </div>
                            <div class="right">
                                <div class="info">
                                    <div>
                                        <label class="btn btn-dark"><a href='/Views/modules/user/gerar_planilha.php' style="text-decoration: none;">Mensal</a></label>
                                    </div>
                                </div>
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
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
         
    <script src="/js/index.js"></script>
</body>
</html>