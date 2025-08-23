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
  <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f9f9f9;
            color: #333;
        }
        .header {
            background: #4b006e;
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
        }
        .table-container {
            overflow-x: auto;
            margin: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }
           td:nth-child(2) {
        text-align: left;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
     
        th {
            background: #f1f1f1;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background: #fafafa;
        }
        .last5 {
            display: flex;
            justify-content: center;
            gap: 5px;
        }
        .circle {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            display: inline-block;
        }
        .team-name {
    text-align: left !important;
    padding-left: 15px; /* opcional, para dar espaço extra */
}


        .last5 {
            display: flex;
            justify-content: center;
            gap: 5px;
        }
        .circle {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;    
            justify-content: center;  
            font-size: 12px;
            font-weight: bold;
            color: white;            
        }

        .win { 
           background-color: #4CAF50; /* verde */
    color: white;}
        .draw { background: gray; 
        border: qpx solid gray; }
        .loss { background: red;
        border: 1px solid red;  }
        .back-link {
            margin: 20px;
            display: inline-block;
            text-decoration: none;
            color: #4b006e;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">Standings</div>

    <div class="table-container">
        <table>
            <tr>
                <th>Pos</th>
                <th class="team-name">Time</th>
                <th>MP</th>
                <th>W</th>
                <th>D</th>
                <th>L</th>
                <th>GF</th>
                <th>GA</th>
                <th>GD</th>
                <th>Pts</th>
                <th>Last 5</th>
            </tr>
            <?php $pos = 1; foreach ($tabela as $linha): ?>
            <tr>
                <td><?= $pos++ ?></td>
             <td class="team-name"><?= $linha['nome'] ?></td>
                <td><?= $linha['jogos'] ?></td>
                <td><?= $linha['vitorias'] ?></td>
                <td><?= $linha['empates'] ?></td>
                <td><?= $linha['derrotas'] ?></td>
                <td><?= $linha['gols_pro'] ?></td>
                <td><?= $linha['gols_contra'] ?></td>
                <td><?= $linha['saldo'] ?></td>
                <td><?= $linha['pontos'] ?></td>
                <td>
               
                <div class="last5">
                    <?php 
                    if (!empty($linha['last5'])) {
                        foreach ($linha['last5'] as $res) {
                            $res = strtoupper(trim($res));
                            $class = '';
                            if ($res === "V") $class = "win";
                            elseif ($res === "E") $class = "draw";
                            elseif ($res === "D") $class = "loss";
                            echo "<span class='circle $class'>$res</span>";
                        }
                    }
                    ?>
                </div>
            

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <a href="index.php" class="back-link">⬅ Voltar</a>
</body>
</html>
