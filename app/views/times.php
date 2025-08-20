<?php
require_once "../controllers/TeamController.php";
$controller = new TeamController();

// Se enviou formulário para criar time
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'create') {
    $nome = $_POST['nome'];
    $controller->create($nome);
}

// Listar todos os times
$times = $controller->listar();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Times</title>
</head>
<body>
<h1>Cadastro de Times</h1>

<form method="POST">
    <input type="text" name="nome" placeholder="Nome do Time" required>
    <button type="submit" name="action" value="create">Cadastrar</button>
</form>

<h2>Times Registrados</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Nome</th>
    </tr>
    <?php foreach ($times as $t): ?>
    <tr>
        <td><?= $t['id'] ?></td>
        <td><?= $t['nome'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<p><a href="index.php">⬅ Voltar</a></p>
</body>
</html>
