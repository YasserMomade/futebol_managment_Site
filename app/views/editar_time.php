<?php
require_once "../controllers/TeamController.php";
$controller = new TeamController();

$msg = "";
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$time = $controller->get($id);

if (!$time) {
    die("Time não encontrado!");
}

// Atualizar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update') {
    $novoNome = trim($_POST['nome']);
    if ($controller->update($id, $novoNome)) {
        $msg = "✅ Time atualizado com sucesso!";
        $time['nome'] = $novoNome; // atualiza localmente
    } else {
        $msg = "❌ Erro ao atualizar o time.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Time</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { background:#f9f9f9; font-family:Arial,sans-serif; padding:20px; }
        h1 { text-align:center; color:#4a148c; margin-bottom:20px; }

        .card {
            background:#fff; max-width:500px; margin:0 auto; padding:20px;
            border-radius:12px; box-shadow:0px 4px 10px rgba(0,0,0,0.1);
        }
        form { display:flex; flex-direction:column; gap:15px; }
        input[type="text"] { padding:12px; border:2px solid #4a148c; border-radius:8px; }
        button {
            padding:12px; border:none; background:#4a148c; color:#fff;
            font-size:16px; border-radius:8px; cursor:pointer; transition:0.3s;
        }
        button:hover { background:#6a1b9a; }

        .msg { text-align:center; margin-bottom:20px; font-weight:bold; }
        .success { color:green; }
        .error { color:red; }

        .back-link {
            display:block; margin-top:20px; text-align:center;
            color:#4a148c; font-weight:bold; text-decoration:none;
        }
        .back-link:hover { color:#6a1b9a; }
    </style>
</head>
<body>

    <h1>Editar Time</h1>

    <?php if ($msg): ?>
        <div class="msg <?= str_contains($msg, '✅') ? 'success' : 'error' ?>">
            <?= $msg ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <form method="POST">
            <input type="text" name="nome" value="<?= htmlspecialchars($time['nome']) ?>" required>
            <button type="submit" name="action" value="update">Salvar Alterações</button>
        </form>
    </div>

    <a href="times.php" class="back-link">⬅ Voltar à lista de times</a>

</body>
</html>
