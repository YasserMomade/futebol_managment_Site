<?php
require_once "../controllers/TeamController.php";
$ctrl = new TeamController();
$tabela = $ctrl->classificacao();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Tabela de Classificação</title>
</head>
<body>
<h1>Classificação do Campeonato</h1>

<table border="1" cellpadding="5">
    <tr>
        <th>Posição</th>
        <th>Time</th>
        <th>Jogos</th> <!-- nova coluna -->
        <th>Pontos</th>
        <th>Vitórias</th>
        <th>Empates</th>
        <th>Derrotas</th>
        <th>Gols Pró</th>
        <th>Gols Contra</th>
        <th>Saldo</th>
    </tr>
    <?php $pos = 1; foreach ($tabela as $linha): ?>
    <tr>
        <td><?= $pos++ ?></td>
        <td><?= $linha['nome'] ?></td>
        <td><?= $linha['jogos'] ?></td> <!-- exibe jogos -->
        <td><?= $linha['pontos'] ?></td>
        <td><?= $linha['vitorias'] ?></td>
        <td><?= $linha['empates'] ?></td>
        <td><?= $linha['derrotas'] ?></td>
        <td><?= $linha['gols_pro'] ?></td>
        <td><?= $linha['gols_contra'] ?></td>
        <td><?= $linha['saldo'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<p><a href="index.php">⬅ Voltar</a></p>
</body>
</html>
