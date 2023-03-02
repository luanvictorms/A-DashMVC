<?php
    $addAtendimento = 0;
    $addGanho = 0;
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
    <link rel="stylesheet" href="/Css/style.css">
    <link rel="shortcut icon" href="https://as2.ftcdn.net/v2/jpg/03/08/29/09/1000_F_308290978_rwOZyOCskMkppXSzNhIAi5WJTMyp7aqp.jpg" type="image/x-icon" />
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand" style="text-align:center">
            <h2><span class="lab la-accusoft"></span>A+Dash</h2>
        </div>

        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="" class="active" style="text-decoration: none;">
                        <span class="las la-igloo"></span>
                        <span>Dashboard</span>
                    </a>
                </li>

                <?php foreach($objServices as $obj): ?>
                    <?php if(!empty($obj)): ?>
                        <li>
                            <a href="" style="text-decoration: none;">
                                <?php if($obj['service_name'] == 'Contabilidade'): ?>
                                    <span class="las la-dollar-sign"></span>
                                <?php elseif($obj['service_name'] == 'Controle de Estoque'): ?>
                                    <span class="las la-box"></span>
                                <?php endif; ?>
                                
                                <span>
                                    <?php if($obj['service_name'] == 'Simple'){

                                    } else if($obj['service_name'] == 'Administrador'){

                                    } else {
                                        echo $obj['service_name'];
                                    }
                                    ?>
                                </span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach;?>
                
            </ul>
        </div>
    </div>

    <div class="main-content">
        <header style="background-color: white;">
            <h2 style="margin-top: 10px">
                <label for="">
                    <span class="las la-bars"></span>
                </label>

                Dashboard
            </h2>

            <div class="search-wrapper" style="margin-top: 10px">
                <span class="las la-calendar-alt"></span>
                <span><?php echo $hoje;?></span>
            </div>

            <div class="user-wrapper">
                <img src="https://media-exp1.licdn.com/dms/image/C4E03AQEFeMyaPIrwBQ/profile-displayphoto-shrink_800_800/0/1655147085070?e=1673481600&v=beta&t=L2t4ERarrgifDUPe_f6qFyVr3yIh9ouLSp_8E943h8s" width ="40px" height="40px" alt="">

                <div>
                    <h4>
                        <?php if(!empty($_SESSION)) {
                            echo $_SESSION['user_name']; 
                        } else {
                            echo $model->user_name;
                        }?>
                    </h4>
                    <?php foreach($objServices as $obj): ?>
                        <?php if(in_array($obj['service_name'] == 'Administrador',$obj)): ?>
                            <small>Super Admin</small>
                        <?php endif; ?>
                        <?php if($obj['service_name'] == 'Simple') :?>
                            <small>Usuario</small>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </header>

        <main>
            <div class="cards">

                <div class="card-single">
                    <div>
                        <?php foreach($objServices as $obj): ?>
                            <?php if(in_array($obj['service_name'] == 'Administrador',$obj)): ?>
                                <h1>R$-<?php echo $costModel->totalCost; ?></h1>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <span>Adicionar Custos Administrativos</span>
                    </div>
                    <div>
                        <label for="modalCusto" class="abrirModal"><span class="las la-plus-circle" style="cursor:pointer"></span></label>
                        <input type="checkbox" class="checkboxModal" id="modalCusto">

                        <div class="modal">
                            <label for="modalCusto" class="fecharModal"><span class="las la-times-circle"></label>
                            
                            <div class="conteudoModal" style="text-align: center;">
                                <h2 style="text-align:center; margin-top:10px">+ Custo administrativo</h2>
                                <form action="/usuario/login/adicionarCusto" method="POST">
                                <div style="margin-top: 30%; padding-left: 20%; padding-right: 20%">

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
                                        <input type="number" id="inputGroupSelect27" class="form-control" name="custo" required>
                                    </div>

                                    <input type="submit" class="btn btn-dark" value="Adicionar Custo">
                                </div>
                                
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <?php foreach($objServices as $obj): ?>
                            <?php if(in_array($obj['service_name'] == 'Administrador',$obj)): ?>
                                <h1>
                                    <?php if(!empty($attendanceModel->attendanceRows)): ?>
                                        <?php $ultimo = count($attendanceModel->attendanceRows);
                                        echo $ultimo; ?>
                                    <?php endif; ?>
                                </h1>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <span>Adicionar Atendimento</span>
                    </div>
                    <div>
                        <label for="modalAtendimento" class="abrirModal"><span class="las la-plus-circle" style="cursor:pointer"></span></label>
                        <input type="checkbox" class="checkboxModal" id="modalAtendimento">

                        <div class="modal">
                            <label for="modalAtendimento" class="fecharModal"><span class="las la-times-circle"></label>
                            
                            <div class="conteudoModal" style="text-align: center;">
                                <h2 style="text-align:center; margin-top:10px">+ Atendimento</h2>
                                <form action="/usuario/login/adicionarAtendimento" method="POST">

                                    <div style="margin-top: 30%; padding-left: 20%; padding-right: 20%">

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
                                                    <option value="PIX">DINHEIRO</option>
                                                    <option value="CREDITO">Cartão de Debito</option>
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
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <?php foreach($objServices as $obj): ?>
                            <?php if(in_array($obj['service_name'] == 'Administrador',$obj)): ?>
                                <h1>
                                    <?php 
                                        $ultimo = count($clientModel->clientRows);
                                        echo $ultimo;
                                    ?>
                                </h1>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <span>Registrar Cliente</span>
                    </div>
                    <div>
                        <label for="modalCliente" class="abrirModal"><span class="las la-plus-circle" style="cursor:pointer"></label>
                        <input type="checkbox" class="checkboxModal" id="modalCliente">

                        <div class="modal">
                            <label for="modalCliente" class="fecharModal"><span class="las la-times-circle" style="color:black;"></label>
                            
                            <div class="conteudoModal" style="text-align: center;">
                                <h2 style="text-align:center; margin-top:10px">+ Cliente</h2>
                                <form action="/usuario/login/adicionarCliente" method="POST">

                                    <div style="margin-top: 30%; padding-left: 20%; padding-right: 20%">

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
                                            <label class="input-group-text" for="inputGroupSelect03">Cel</label>
                                            <input type="text" id="inputGroupSelect03" class="form-control" name="celular">
                                        </div>

                                        <input type="submit" class="btn btn-dark" value="Adicionar Cliente">
                                    </div>
                                
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <?php foreach($objServices as $obj): ?>
                            <?php if(in_array($obj['service_name'] == 'Administrador',$obj)): ?>
                                <h1>
                                    <?php 
                                        $ultimo = count($saleModel->saleRows);
                                        echo $ultimo;
                                    ?>
                                </h1>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <span>Vender Produto</span>
                    </div>
                    <div>
                        <label for="modalVendas" class="abrirModal"><span class="las la-plus-circle" style="cursor:pointer"></span></label>
                        <input type="checkbox" class="checkboxModal" id="modalVendas">

                        <div class="modal">
                        <label for="modalVendas" class="fecharModal"><span class="las la-times-circle" style="color:black;"></label>
                            
                            <div class="conteudoModal" style="text-align: center;">
                                <h2 style="text-align:center; margin-top:10px">+ Venda</h2>
                                <form action="/usuario/login/adicionarVenda" method="POST">
                                    <div style="margin-top: 30%; padding-left: 20%; padding-right: 20%">

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
                                            <input type="number" id="inputGroupSelect03" class="form-control" name="preco">
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
                                <div>
                                    <!--Modal de adicionar um novo produto-->
                                    <label for="modalNewTypeProduct" class="abrirModal btn btn-dark" style="margin-top: 20px">
                                        <span style="font-size:small; color:white">Adicionar Novos Produtos</span>
                                    </label>
                                    <input type="checkbox" class="checkboxModal" id="modalNewTypeProduct">

                                    <div class="modal">
                                        <label for="modalNewTypeProduct" class="fecharModal"><span class="las la-times-circle" style="color:black;"></label>
                                        
                                        <div class="conteudoModal" style="text-align: center;">
                                            <h2 style="text-align:center; margin-top:10px">Adicionar Novo Produto</h2>
                                            <form action="/usuario/login/adicionarNovoProduto" method="POST">
                                            <div style="margin-top: 30%; padding-left: 20%; padding-right: 20%">

                                                <input type="hidden" name="tipo_produtoAction">

                                                <div class="input-group mb-3">
                                                    <label class="input-group-text" for="inputGroupSelect01">Nome do Produto</label>
                                                    <input type="text" id="inputGroupSelect01" class="form-control" name="nome" required>
                                                </div>

                                                <input type="submit" class="btn btn-dark" value="Adicionar Novo Produto">
                                            </div>
                                            
                                            </form>
                                        </div>
                                    </div>
                                
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="cards">

                <?php foreach($objServices as $obj): ?>
                    <?php if(in_array($obj['service_name'] == 'Administrador',$obj)): ?>

                        <div class="card-single">
                            <div>
                                <h1>R$<?php echo $attendanceModel->attendanceProfit; ?></h1>
                                <span>
                                    <?php if($attendanceModel->attendanceProfit > 0){
                                        echo 'Lucro';
                                    } else {
                                        echo 'Prejuizo';
                                    }?>
                                </span>
                            </div>
                            <div>
                                <span class="lab la-google-wallet"></span>
                            </div>
                        </div>

                    <?php endif; ?>
                <?php endforeach; ?>

                

                <div class="card-single">
                    <div>
                        <?php foreach($objServices as $obj): ?>
                            <?php if(in_array($obj['service_name'] == 'Administrador',$obj)): ?>
                                <?php if(!empty($valeModel->totalVale)): ?>
                                    <h1>R$-<?php echo $valeModel->totalVale; ?></h1>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <span>Adicionar Vale</span>
                    </div>
                    <div>
                        <label for="modalVale" class="abrirModal"><span class="las la-plus-circle" style="cursor:pointer"></span></label>
                        <input type="checkbox" class="checkboxModal" id="modalVale">

                        <div class="modal">
                            <label for="modalVale" class="fecharModal"><span class="las la-times-circle" style="color:black;"></label>
                            
                            <div class="conteudoModal" style="text-align: center;">
                                <h2 style="text-align:center; margin-top:10px">+ Vale</h2>

                                <form action="/usuario/login/adicionarVale" method="POST">
                                    <div style="margin-top: 30%; padding-left: 20%; padding-right: 20%">

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
                                            <input type="number" id="inputGroupSelect05" class="form-control" name="value" required>
                                        </div>

                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="inputGroupSelect04">Data do Vale</label>
                                            <input type="date" id="inputGroupSelect04" class="form-control" name="date" value="<?php echo $hoje;?>" required>
                                        </div>

                                        <input type="submit" class="btn btn-dark" value="Adicionar Vale">
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="recent-grid">
                <div class="projects">
                    <div class="card">
                        <div class="card-header">
                            <h3>Atendimento Diario</h3>

                            <label for="modalAtendimentoDiario" class="btn btn-dark">Ver Atendimentos<span class="las la-arrow-right"></span></label>
                            <input type="checkbox" class="checkboxModal" id="modalAtendimentoDiario">

                            <div class="modal">
                                <label for="modalAtendimentoDiario" class="fecharModal"><span class="las la-times-circle"></label>
                                
                                <div class="conteudoModal" style="text-align: center;">
                                    <h2 style="text-align:center; margin-top:10px">Todos os Atendimentos</h2>

                                    <table width="100%" style="margin-top: 80px">
                                        <thead>
                                            <tr class="tr-dark">
                                                <td class="dark-table">Serviço</td>
                                                <td class="dark-table">Atendente</td>
                                                <td class="dark-table">Cliente</td>
                                                <td class="dark-table">Valor</td>
                                                <td class="dark-table">Status</td>
                                                <td class="dark-table">Data</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                            <tbody>
                                                <?php if(!empty($attendanceModel->attendanceRows)): ?>
                                                    <?php foreach($attendanceModel->attendanceRows as $row): ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $row['attendance_name']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row['worker_name']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row['client_name']; ?>
                                                            </td>
                                                            <?php 
                                                                $discount = $row['attendance_discount'] * $row['attendance_price'];
                                                                $realPrice = $row['attendance_price'] - $discount;
                                                            ?>
                                                            <td><?php echo "R$" . "{$realPrice}"; ?></td>
                                                            <td>
                                                                <span class="status green"></span>
                                                                <?php echo $row['attendance_payment'];?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row['attendance_date']; ?>
                                                            </td>
                                                            <!--<td><a href="/usuario/atendimento/update?id=">Editar</a></td>-->
                                                            <td><a style="text-decoration: none; text-align:center" href="/usuario/atendimento/delete?id=<?= $row['attendance_calls_id']?>&mode=atendimento" class="las la-trash"></a></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                    </table>

                                    <!--Modal de adicionar um novo serviço-->
                                    <label for="modalNewTypeAttendance" class="abrirModal btn btn-dark" style="margin-top: 20px">
                                        <span class="las la-plus-circle"></span>
                                        <span>Adicionar Serviços</span>
                                    </label>
                                    <input type="checkbox" class="checkboxModal" id="modalNewTypeAttendance">

                                    <div class="modal">
                                        <label for="modalNewTypeAttendance" class="fecharModal"><span class="las la-times-circle"></label>
                                        
                                        <div class="conteudoModal" style="text-align: center;">
                                            <h2 style="text-align:center; margin-top:10px">Adicionar Novo Tipo de Serviço</h2>
                                            <form action="/usuario/login/adicionarNovoTipoServico" method="POST">
                                            <div style="margin-top: 30%; padding-left: 20%; padding-right: 20%">

                                                <input type="hidden" name="tipo_servicoAction">

                                                <div class="input-group mb-3">
                                                    <label class="input-group-text" for="inputGroupSelect01">Nome do Serviço</label>
                                                    <input type="text" id="inputGroupSelect01" class="form-control" name="nome" required>
                                                </div>

                                                <div class="input-group mb-3">
                                                    <label class="input-group-text" for="inputGroupSelect01">Preço do Serviço: R$</label>
                                                    <input type="number" id="inputGroupSelect01" class="form-control" name="preco" required>
                                                </div>
                                                
                                                <input type="submit" class="btn btn-dark" value="Adicionar Novo Serviço">
                                            </div>
                                            
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        
                        <div class="card-body">
                            <table width="100%">
                                <thead>
                                    <tr class="tr-dark">
                                        <td class="dark-table">Serviço</td>
                                        <td class="dark-table">Atendente</td>
                                        <td class="dark-table">Cliente</td>
                                        <td class="dark-table">Valor</td>
                                        <td class="dark-table">Tipo Pgto</td>
                                        <td class="dark-table">Data</td>
                                    </tr>
                                </thead>
                                    <tbody>
                                        <?php if(!empty($attendanceModel->attendanceRows)): ?>
                                            <?php foreach($attendanceModel->attendanceRows as $row): ?>
                                                <?php if($hoje <= $row['attendance_date']): ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $row['attendance_name']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['worker_name']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['client_name']; ?>
                                                        </td>
                                                        <?php 
                                                            $discount = $row['attendance_discount'] * $row['attendance_price'];
                                                            $realPrice = $row['attendance_price'] - $discount;
                                                        ?>
                                                        <td><?php echo "R$" . "{$realPrice}"; ?></td>
                                                        <td>
                                                            <span class="status green"></span>
                                                            <?php echo $row['attendance_payment']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['attendance_date']; ?>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="customers">

                    <div class="card">

                        <div class="card-header">
                            <h3>Clientes</h3>

                            <label for="modalClientesNovos" class="btn btn-dark">Ver<span class="las la-arrow-right"></span></label>
                            <input type="checkbox" class="checkboxModal" id="modalClientesNovos">

                            <div class="modal">
                                <label for="modalClientesNovos" class="fecharModal"><span class="las la-times-circle"></span></label>
                                
                                <div class="conteudoModal" style="text-align: center;">
                                    <h2 style="text-align:center; margin-top:10px">Todos os Clientes</h2>

                                    <table width="100%" style="margin-top: 80px">
                                        <thead>
                                            <tr class="tr-dark">
                                                <td class="dark-table">Cliente</td>
                                                <td class="dark-table">Endereço</td>
                                                <td class="dark-table">Celular</td>
                                                <td class="dark-table">Qtd. Atendimentos</td>
                                                <td class="dark-table"></td>
                                            </tr>
                                        </thead>
                                            <tbody>
                                                <?php if(!empty($clientModel->clientRows)): ?>
                                                    <?php foreach($clientModel->clientRows as $rowClientes): ?>
                                                        <tr style="text-align:center">
                                                            <td>
                                                                <?php echo $rowClientes['client_name']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $rowClientes['client_address']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $rowClientes['client_phone']; ?>
                                                            </td>
                                                            <td>
                                                                <?php foreach($attendanceModel->attendanceRows as $attendanceCall): ?>
                                                                    <?php if($attendanceCall['client_id'] == $rowClientes['client_id']){
                                                                        $addAtendimento = $addAtendimento + 1;
                                                                        
                                                                    }
                                                                    ?>
                                                                <?php endforeach; ?>
                                                                <?php echo $addAtendimento; ?>
                                                                
                                                            </td>
                                                            <td>
                                                                <?php if($addAtendimento == 0): ?>
                                                                    <a style="text-decoration: none;  text-align:center" href="/usuario/clientes/delete?id=<?= $rowClientes['client_id']?>&mode=clientes" class="las la-trash"></a>
                                                                <?php endif; ?>
                                                            </td>
                                                            <?php $addAtendimento = 0; ?>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                    </table>
                                </div>
                            </div>


                        </div>
                        
                        <div class="card-body">
                            <div class="customer">
                                <div>
                                    <?php $i = count($clientModel->clientRows);?>
                                    <?php $menos2 = $i - 2; ?>
                                    <?php foreach ($clientModel->clientRows as $row): ?>
                                        <?php $i = $i - 1; ?>
                                        <?php if($i >= $menos2): ?>
                                            <div>
                                                <h6><?php echo $row['client_name']; ?></h6>
                                                <small>Novo Cliente</small>
                                                <hr>
                                             </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="projects">
                    <div class="card">
                        <div class="card-header">
                            <h3>Custo Administrativo Diario</h3>

                            <label for="modalCustoDiario" class="btn btn-dark">Ver Custos<span class="las la-arrow-right"></span></label>
                            <input type="checkbox" class="checkboxModal" id="modalCustoDiario">

                            <div class="modal">
                                <label for="modalCustoDiario" class="fecharModal"><span class="las la-times-circle"></label>
                                
                                <div class="conteudoModal" style="text-align: center;">
                                    <h2 style="text-align:center; margin-top:10px">Todos os Custos Administrativos</h2>

                                    <table width="100%" style="margin-top: 80px">
                                        <thead>
                                            <tr class="tr-dark">
                                                <td class="dark-table">Valor</td>
                                                <td class="dark-table">Motivo</td>
                                                <td class="dark-table">Data</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($costModel->costRows)): ?>
                                                <?php foreach($costModel->costRows as $row): ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo "R$" . "{$row['cost_value']},00"; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['cost_reason']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['cost_date']; ?>
                                                        </td>
                                                        <td>
                                                            <a style="text-decoration: none;  text-align:center" href="/usuario/custo/delete?id=<?= $row['cost_id']?>&mode=custo" class="las la-trash"></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <table width="100%">
                                <thead>
                                    <tr class="tr-dark">
                                        <td class="dark-table">Valor</td>
                                        <td class="dark-table">Motivo</td>
                                        <td class="dark-table">Data</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($costModel->costRows)): ?>
                                        <?php foreach($costModel->costRows as $row): ?>
                                            <?php if(!empty($row['cost_date'])): ?>
                                                <?php if($hoje <= $row['cost_date']): ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo "R$-" . "{$row['cost_value']},00"; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['cost_reason']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['cost_date']; ?>
                                                        </td>
                                                    </tr>
                                                <?php endif;?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="customers">

                    <div class="card">

                        <div class="card-header">
                            <h3>Gerente</h3>
                        </div>
                        
                        <div class="card-body">
                            <div class="customer" style="text-align: center">
                                <div>
                                    <img src="/img/301139016_152446094065793_1740184720443437208_n.jpg" width="40px" height="40px" alt="">
                                    <div>
                                        <h4>Diego Jack</h4>
                                        <small>CEO/Gerente</small>
                                    </div>
                                </div>
                                <div>
                                    <span class="las la-user-circle"></span>
                                    <span class="las la-comment"></span>
                                    <span class="las la-phone"></span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                
                <?php foreach($objServices as $obj): ?>
                    <?php if(!empty($obj)): ?>
                        <?php if($obj['service_name'] == 'Contabilidade'): ?>
                            <div class="projects">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Ganho por Atendimento</h3>
                                    </div>
                                    
                                    <div class="card-body">
                                        <table width="100%">
                                            <thead>
                                                <tr class="tr-dark">
                                                    <td class="dark-table">Nome</td>
                                                    <td class="dark-table">Ganhos</td>
                                                </tr>
                                            </thead>
                                                <tbody>
                                                    <?php foreach($workerModel->workerRows as $obj): ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo $obj['worker_name']; ?>
                                                                </td>
                                                                <td>

                                                                    <?php foreach($attendanceModel->attendanceRows as $attendanceCall): ?>
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
                                                                    <?php endforeach; ?>
                                                                    <?php if($obj['worker_name'] == 'Vitor'): ?>
                                                                        <?php $addGanho = $addGanho * 0.43; ?>
                                                                        <?php echo "R$" . "$addGanho"; ?>
                                                                    <?php else: ?>
                                                                        <?php echo "R$" . "$addGanho"; ?>
                                                                    <?php endif; ?>
                                                                    <?php $addGanho = 0; ?>
                                                                </td>
                                                            </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="customers">

                                <div class="card">

                                    <div class="card-header">
                                        <h3>Relatorio XLS</h3>
                                    </div>
                                    
                                    <div class="card-body">
                                        <div class="customer" style="text-align: center;">
                                            <div>
                                                <label class="btn btn-dark"><a href='/Views/modules/user/gerar_planilha.php' style="text-decoration: none;">Gerar Relatorio Excel Mensal</a></label>
                                            </div>
                                            <div style="margin-top: 20px;">
                                                <label class="btn btn-dark"><a href='/Views/modules/user/gerar_planilhaDiario.php' style="text-decoration: none;">Gerar Relatorio Excel Diario</a></label>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

</body>
</html>