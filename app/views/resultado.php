<?php
require_once "../controllers/ResultController.php";
require_once "../controllers/MatchController.php";

$resultCtrl = new ResultController();
$matchCtrl = new MatchController();

// Listar partidas para o combo
$matches = $matchCtrl->listar();

// Se enviou resultado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'resultado') {
    $match_id = $_POST['partida_id'];
    $gols_casa = $_POST['gols_casa'];
    $gols_fora = $_POST['gols_fora'];

    // Verifica se já existe resultado
    $existing = $resultCtrl->getByMatch($match_id);
    if ($existing) {
        $resultCtrl->update($match_id, $gols_casa, $gols_fora);
    } else {
        $resultCtrl->create($match_id, $gols_casa, $gols_fora);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultados</title>
</head>
<body>
<h1>Lançar Resultado</h1>

<form method="POST">
    <label>Partida:
        <select name="partida_id" required>
            <?php foreach ($matches as $m): ?>
                <option value="<?= $m['id'] ?>">
                    Rodada <?= $m['rodada'] ?> - <?= $m['time_casa'] ?> x <?= $m['time_fora'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br><br>

    <label>Gols Time da Casa: <input type="number" name="gols_casa" required></label><br><br>
    <label>Gols Time Visitante: <input type="number" name="gols_fora" required></label><br><br>

    <button type="submit" name="action" value="resultado">Salvar Resultado</button>
</form>

<p><a href="../index.php">⬅ Voltar</a></p>
</body>
</html>
