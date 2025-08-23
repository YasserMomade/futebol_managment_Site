<?php
require_once "../controllers/ResultController.php";
require_once "../controllers/MatchController.php";

$resultCtrl = new ResultController();
$matchCtrl = new MatchController();

// Listar partidas para o combo
$matches = $matchCtrl->listarSemResultado();

// Variáveis de mensagem
$mensagem = '';
$tipo = '';
$partidaSalva = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'resultado') {
    $match_id = $_POST['partida_id'];
    $gols_casa = $_POST['gols_casa'];
    $gols_fora = $_POST['gols_fora'];

    try {
        $existing = $resultCtrl->getByMatch($match_id);
        if ($existing) {
            $resultCtrl->update($match_id, $gols_casa, $gols_fora);
        } else {
            $resultCtrl->create($match_id, $gols_casa, $gols_fora);
        }

        $matchCtrl->atualizarResultado($match_id, $gols_casa, $gols_fora);

        $mensagem = "Resultado salvo com sucesso!";
        $tipo = "sucesso";
        $partidaSalva = $match_id;
    } catch (Exception $e) {
        $mensagem = "Erro ao salvar resultado: " . $e->getMessage();
        $tipo = "erro";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Lançar Resultado</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #f5f5f5;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 500px;
    margin: 50px auto;
    background: #fff;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

h1 {
    text-align: center;
    color: #4a148c;
    margin-bottom: 25px;
}

label {
    display: block;
    margin-bottom: 15px;
    font-weight: bold;
    color: #333;
}

input[type="number"], select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    margin-top: 5px;
    font-size: 16px;
}

button {
    width: 100%;
    padding: 12px;
    background: #4a148c;
    color: #fff;
    font-size: 16px;
    font-weight: bold;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s;
}

button:hover {
    background: #6a1b9a;
}

a {
    display: block;
    text-align: center;
    margin-top: 15px;
    color: #4a148c;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

.mensagem {
    text-align: center;
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 6px;
}

.sucesso {
    background: #dcedc8;
    color: #33691e;
}

.erro {
    background: #ffcdd2;
    color: #b71c1c;
}

/* Responsividade */
@media (max-width: 500px) {
    .container {
        margin: 30px 15px;
        padding: 20px;
    }
}
</style>
</head>
<body>

<div class="container">
    <h1>Lançar Resultado</h1>

    <?php if($mensagem): ?>
        <div id="mensagem" class="mensagem <?= $tipo ?>"><?= $mensagem ?></div>
    <?php endif; ?>

    <form method="POST" id="resultadoForm">
        <label>Partida:
            <select name="partida_id" id="partidaSelect" required>
                <option value="">Selecione...</option>
                <?php foreach ($matches as $m): ?>
                    <?php if ($partidaSalva != $m['id']): // remove a partida já salva ?>
                        <option value="<?= $m['id'] ?>" 
                                data-casa="<?= htmlspecialchars($m['time_casa']) ?>" 
                                data-fora="<?= htmlspecialchars($m['time_fora']) ?>">
                            Rodada <?= $m['rodada'] ?> - <?= $m['time_casa'] ?> x <?= $m['time_fora'] ?>
                        </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </label>

        <label id="labelCasa">Gols Time da Casa:
            <input type="number" name="gols_casa" required>
        </label>

        <label id="labelFora">Gols Time Visitante:
            <input type="number" name="gols_fora" required>
        </label>

        <button type="submit" name="action" value="resultado">Salvar Resultado</button>
    </form>

    <a href="index.php">⬅ Voltar</a>
</div>

<script>
// Atualizar labels dinamicamente
document.getElementById('partidaSelect').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    const casa = selected.getAttribute('data-casa');
    const fora = selected.getAttribute('data-fora');
    if(casa && fora) {
        document.getElementById('labelCasa').innerHTML = `Gols do ${casa}: <input type="number" name="gols_casa" required>`;
        document.getElementById('labelFora').innerHTML = `Gols do ${fora}: <input type="number" name="gols_fora" required>`;
    }
});

// Mensagem desaparece após 5s
const msg = document.getElementById('mensagem');
if(msg) {
    setTimeout(() => {
        msg.style.display = 'none';
    }, 5000);
}
</script>

</body>
</html>
