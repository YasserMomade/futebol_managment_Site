<?php
require_once "../controllers/MatchController.php";

$matchCtrl = new MatchController();
$matches = $matchCtrl->listar(); 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Rodadas e Jogos</title>
<style>
body {
    font-family: Arial, sans-serif;
    background:#f5f5f5;
    margin:0;
    padding:0;
}
header {
    background: #4a148c;
    color: #fff;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between; /* título à esquerda, botão à direita */
    align-items: center;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    
}
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }

header h1 {
    margin: 0;
    font-size: 24px;
}

header a {
    color: #fff;
    text-decoration: none;
    background: #6a1b9a;
    padding: 8px 15px;
    border-radius: 6px;
    transition: background 0.3s;
    white-space: nowrap; /* impede quebrar em 2 linhas */
    margin: auto 0 0 20px;
}

header a:hover {
    background: #7b1fa2;
}
/* Responsividade */
@media (max-width: 600px) {
    header {
        flex-direction: column; /* empilha título e botão */
        align-items: flex-start; /* alinha tudo à esquerda */
    }
    header a {
        margin-top: 10px; /* espaço entre título e botão */
    }
    
}

.container {
    width: 80%;
    margin: 100px auto 20px auto; /* mais espaço no topo para não cobrir o header */
}



.round {
    margin-bottom: 30px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.round h2 {
    background:#4a148c;
    color:#fff;
    margin:0;
    padding:10px;
    border-radius: 8px 8px 0 0;
}
.match {
    display: grid;
    grid-template-columns: 1fr 40px 20px 40px 1fr;
    align-items: center;
    padding: 12px;
    border-bottom: 1px solid #eee;
}
.match:last-child {
    border-bottom: none;
}
.team {
    display:flex;
    justify-content: flex-end;
    align-items:center;
    padding: 0 10px;
}
.team:last-of-type {
    justify-content: flex-start;
}
.score {
    text-align:center;
    font-size: 18px;
    font-weight:bold;
}
.separator {
    text-align:center;
    font-size: 18px;
    font-weight:bold;
}
.win { color: green; }
.lose { color: red; }
.draw { color: gray; }
</style>
</head>
<body>

<header>
    <h1>Jogos</h1>
    <a href="index.php">⬅ Voltar ao Menu</a>
</header>

<div class="container">
<?php
$current_round = 0;
foreach($matches as $m):
    if($m['rodada'] != $current_round):
        if($current_round != 0) echo "</div>"; 
        $current_round = $m['rodada'];
        echo "<div class='round'><h2>Rodada $current_round</h2>";
    endif;

    // Definir cores
    $classCasa = $classFora = "draw";
    if ($m['status'] == 'finalizada') {
        if ($m['gols_casa'] > $m['gols_fora']) {
            $classCasa = "win";
            $classFora = "lose";
        } elseif ($m['gols_fora'] > $m['gols_casa']) {
            $classCasa = "lose";
            $classFora = "win";
        }
    }
?>
    <div class="match">
        <div class="team"><?= htmlspecialchars($m['time_casa']) ?></div>

        <div class="score <?= ($m['status'] == 'finalizada') ? $classCasa : '' ?>">
            <?= ($m['status'] == 'finalizada') ? $m['gols_casa'] : '' ?>
        </div>

        <div class="separator">
            <?= ($m['status'] == 'finalizada') ? "-" : "VS" ?>
        </div>

        <div class="score <?= ($m['status'] == 'finalizada') ? $classFora : '' ?>">
            <?= ($m['status'] == 'finalizada') ? $m['gols_fora'] : '' ?>
        </div>

        <div class="team"><?= htmlspecialchars($m['time_fora']) ?></div>
    </div>
<?php
endforeach;
if($current_round != 0) echo "</div>"; 
?>
</div>

</body>
</html>
