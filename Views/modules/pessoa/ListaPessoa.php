<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Pessoas</title>

    <style>
        #btn{
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <?php if(count($model->rows) == 0): ?>
        Nenhum registro encontrado
    <?php else: ?>
        <table>
            <tr>
                <th></th>
                <th>Id</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Data Nascimento</th>
            </tr>

            <?php foreach($model->rows as $row): ?>
            <tr>
                <td>
                <a href="/pessoa/delete?id=<?= $row->id?>"><button>Deletar Registro</button></a>
                    
                </td>

                <td><?= $row->id ?></td>

                <td>
                    <a href="/pessoa/form?id=<?= $row->id?>">
                        <?= $row->nome ?>
                    </a>
                </td>

                <td><?= $row->cpf ?></td>

                <td><?= $row->data_nascimento ?></td>

            </tr>
            <?php endforeach;?>

        </table>
    <?php endif ?>

    <a href="/pessoa/form"><button id="btn">Adicionar Nova Pessoa</button></a>
</body>
</html>

