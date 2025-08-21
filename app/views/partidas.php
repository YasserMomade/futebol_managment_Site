<?php
require_once "../controllers/MatchController.php";
require_once "../controllers/TeamController.php";

$teamCtrl = new TeamController();
$matchCtrl = new MatchController();
$matches = $matchCtrl->listar() ?? [];

$rodadaSelecionada = null;
$mensagem = "";
$tipoMensagem = "";

// Listar times para o combo
$times = $teamCtrl->listar();

// Se enviou formulário para criar partida
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;

if ($action === 'create') {
    $rodada = $_POST['rodada'] ?? null;
    $time_casa = $_POST['time_casa'] ?? null;
    $time_fora = $_POST['time_fora'] ?? null;

    if ($rodada && $time_casa && $time_fora) {
        $resultado = $matchCtrl->create($rodada, $time_casa, $time_fora);

        $mensagem = $resultado['mensagem'];
        $tipoMensagem = $resultado['ok'] ? "sucesso" : "erro";

        // Atualiza a lista de partidas **sempre**
        $matches = $matchCtrl->listar() ?? [];
    }

    $rodadaSelecionada = $_POST['rodada'] ?? null;
}

    $rodadaSelecionada = $_POST['rodada'] ?? null;
}

// Listar times disponíveis
if (!empty($rodadaSelecionada)) {
    $times = $teamCtrl->listarDisponiveis($rodadaSelecionada);
} else {
    $times = $teamCtrl->listar();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Gerenciar Partidas</title>
<style>
/* --- Design base --- */
body {
    font-family: Arial, sans-serif;
    background-color: #f9f9fb;
    margin: 0;
    padding: 20px;
    color: #333;
}
h1, h2 { color: #4b006e; }
.container {
    max-width: 900px;
    margin: auto;
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
}
form { margin-bottom: 25px; }
label { font-weight: bold; display: block; margin-top: 15px; color: #4b006e; }
select, button { width: 100%; padding: 10px; margin-top: 8px; border-radius: 6px; border: 1px solid #ccc; font-size: 15px; }
button {
    background-color: #4b006e;
    color: #fff;
    border: none;
    cursor: pointer;
    margin-top: 20px;
    transition: background 0.3s;
}
button:hover { background-color: #360050; }
table { width: 100%; border-collapse: collapse; margin-top: 15px; }
th { background-color: #4b006e; color: white; padding: 12px; }
td { padding: 10px; border-bottom: 1px solid #ddd; text-align: center; }
tr:nth-child(even) { background-color: #f6f6f6; }
.mensagem {
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 15px;
    font-weight: bold;
    text-align: center;
}
.sucesso { background: #d1ffd8; color: #006e2e; border: 1px solid #00a651; }
.erro { background: #ffd1d1; color: #6e0000; border: 1px solid #a60000; }
a { display: inline-block; margin-top: 20px; text-decoration: none; color: #4b006e; font-weight: bold; }
a:hover { text-decoration: underline; }

/* --- Toast --- */
#toast {
    visibility: hidden;
    min-width: 250px;
    margin-left: -125px;
    background-color: #333;
    color: #fff;
    text-align: center;
    border-radius: 8px;
    padding: 16px;
    position: fixed;
    z-index: 999;
    left: 50%;
    bottom: 30px;
    font-size: 17px;
}
#toast.show { visibility: visible; animation: fadein 0.5s, fadeout 0.5s 3s; }
@keyframes fadein { from {bottom: 0; opacity: 0;} to {bottom: 30px; opacity: 1;} }
@keyframes fadeout { from {bottom: 30px; opacity: 1;} to {bottom: 0; opacity: 0;} }
</style>
</head>
<body>
<div class="container">
    <h1>Cadastro de Partidas</h1>

    <?php if ($mensagem): ?>
        <div class="mensagem <?= $tipoMensagem ?>"><?= $mensagem ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Rodada:</label>
        <select name="rodada" required onchange="this.form.submit()">
            <option value="">-- Escolha --</option>
            <option value="1" <?= ($rodadaSelecionada == 1 ? 'selected' : '') ?>>1ª Rodada</option>
            <option value="2" <?= ($rodadaSelecionada == 2 ? 'selected' : '') ?>>2ª Rodada</option>
            <option value="3" <?= ($rodadaSelecionada == 3 ? 'selected' : '') ?>>3ª Rodada</option>
            <option value="4" <?= ($rodadaSelecionada == 4 ? 'selected' : '') ?>>4ª Rodada</option>
            <option value="5" <?= ($rodadaSelecionada == 5 ? 'selected' : '') ?>>5ª Rodada</option>
            <option value="6" <?= ($rodadaSelecionada == 6 ? 'selected' : '') ?>>6ª Rodada</option>
        </select>

       <?php if ($rodadaSelecionada): ?>
    <?php if (!empty($times)): ?>
        <label>Time da Casa:</label>
        <select name="time_casa" required>
            <?php foreach ($times as $t): ?>
                <option value="<?= $t['id'] ?>"><?= $t['nome'] ?></option>
            <?php endforeach; ?>
        </select>

        <label>Time Visitante:</label>
        <select name="time_fora" required>
            <?php foreach ($times as $t): ?>
                <option value="<?= $t['id'] ?>"><?= $t['nome'] ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit" name="action" value="create">Cadastrar Partida</button>
    <?php else: ?>
        <div class="mensagem erro">⚠️ Todos os jogos desta rodada já foram cadastrados!</div>
    <?php endif; ?>
<?php endif; ?>
    </form>

    <h2>Partidas Cadastradas</h2>
    <table>
        <tr>
            <th>Rodada</th>
            <th>Casa</th>
            <th>Visitante</th>
            <th>Status</th>
        </tr>
        <?php foreach ($matches as $m): ?>
            <tr>
                <td><?= $m['rodada'] ?></td>
                <td><?= $m['time_casa'] ?></td>
                <td><?= $m['time_fora'] ?></td>
                <td><?= $m['status'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="index.php">⬅ Voltar</a>
</div>

<!-- Toast -->
<div id="toast"><?= $mensagem ?></div>

<script>
<?php if ($mensagem): ?>
    var toast = document.getElementById("toast");
    toast.className = "show";
    setTimeout(function(){ toast.className = toast.className.replace("show",""); }, 3500);
<?php endif; ?>
</script>

</body>
</html>
