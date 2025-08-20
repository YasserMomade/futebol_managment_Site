<?php
require_once "../controllers/MatchController.php";
require_once "../controllers/TeamController.php";

$teamCtrl = new TeamController();
$matchCtrl = new MatchController();

// Listar times para o combo
$times = $teamCtrl->listar();

// Se enviou formulário para criar partida
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'create') {
    $rodada = $_POST['rodada'];
    $time_casa = $_POST['time_casa'];
    $time_fora = $_POST['time_fora'];
    $matchCtrl->create($rodada, $time_casa, $time_fora);
}

// Listar todas partidas
$matches = $matchCtrl->listar();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Partidas</title>
</head>
<body>
<h1>Cadastro de Partidas</h1>

<form method="POST">
    <label>Rodada:
        <select name="rodada" required>
            <option value="1">1ª Rodada</option>
            <option value="2">2ª Rodada</option>
        </select>
    </label><br><br>

    <label>Time da Casa:
        <select name="time_casa" required>
            <?php foreach ($times as $t): ?>
                <option value="<?= $t['id'] ?>"><?= $t['nome'] ?></option>
            <?php endforeach; ?>
        </select>
    </label><br><br>

    <label>Time Visitante:
        <select name="time_fora" required>
            <?php foreach ($times as $t): ?>
                <option value="<?= $t['id'] ?>"><?= $t['nome'] ?></option>
            <?php endforeach; ?>
        </select>
    </label><br><br>

    <button type="submit" name="action" value="create">Cadastrar Partida</button>
</form>

<h2>Partidas Cadastradas</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Rodada</th>
        <th>Casa</th>
        <th>Visitante</th>
    </tr>
    <?php foreach ($matches as $m): ?>
    <tr>
        <td><?= $m['id'] ?></td>
        <td><?= $m['rodada'] ?></td>
        <td><?= $m['time_casa'] ?></td>
        <td><?= $m['time_fora'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<p><a href="index.php">⬅ Voltar</a></p>
</body>
</html>
