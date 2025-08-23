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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f9f9f9;
            color: #333;
            padding: 20px;
        }

        h1, h2 {
            text-align: center;
            color: #4a148c;
            margin-bottom: 20px;
        }

        /* Card do formulário */
        .card {
            background: #fff;
            max-width: 500px;
            margin: 0 auto 30px auto;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input[type="text"] {
            padding: 12px;
            border: 2px solid #4a148c;
            border-radius: 8px;
            outline: none;
            transition: 0.3s;
        }

        input[type="text"]:focus {
            border-color: #6a1b9a;
            box-shadow: 0 0 6px rgba(74, 20, 140, 0.4);
        }

        button {
            padding: 12px;
            border: none;
            background: #4a148c;
            color: #fff;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #6a1b9a;
        }

        /* Tabela responsiva */
        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 14px;
            text-align: left;
        }

        th {
            background: #4a148c;
            color: #fff;
        }

        tr:nth-child(even) {
            background: #f3e5f5;
        }

        tr:hover {
            background: #ede7f6;
        }

        /* Link voltar */
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #4a148c;
            font-weight: bold;
            text-decoration: none;
            transition: 0.3s;
        }

        .back-link:hover {
            color: #6a1b9a;
        }
    </style>
</head>
<body>

    <h1>Cadastro de Times</h1>

    <div class="card">
        <form method="POST">
            <input type="text" name="nome" placeholder="Digite o nome do time" required>
            <button type="submit" name="action" value="create">Cadastrar</button>
        </form>
    </div>

    <h2>Times Registrados</h2>
    <div class="table-container">
        <table>
            <tr>

                <th>Nome</th>
            </tr>
            <?php foreach ($times as $t): ?>
            <tr>
                <td><?= $t['nome'] ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <p style="text-align:center;">
        <a href="index.php" class="back-link">⬅ Voltar ao menu</a>
    </p>

</body>
</html>
