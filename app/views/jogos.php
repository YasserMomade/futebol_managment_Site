<?php
require_once "../controllers/MatchController.php";

$matchCtrl = new MatchController();
$matches = $matchCtrl->listar(); // retorna todas as partidas
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Rodadas e Jogos</title>
<style>
body { font-family: Arial, sans-serif; background:#f5f5f5; margin:0; padding:0; }
.round { margin:20px auto; width:90%; }
.round h2 { background:#4a148c; color:#fff; padding:10px; }
.match { display:flex; justify-content:space-between; background:#fff; margin:5px 0; padding:10px; border-radius:5px; align-items:center; }
.team { flex:1; display:flex; align-items:center; }
.team img { width:25px; height:25px; margin-right:5px; }
.score { width:50px; text-align:center; font-weight:bold; }
.date { width:100px; text-align:center; color:#555; }
</style>
</head>
<body>

<?php
$current_round = 0;
foreach($matches as $m):
    if($m['rodada'] != $current_round):
        $current_round = $m['rodada'];
        echo "<div class='round'><h2>Matchday $current_round</h2>";
    endif;
?>
    <div class="match">
        <div class="team">
            <!-- você pode adicionar img do time se quiser -->
            <?= $m['time_casa'] ?>
        </div>
        <div class="score">
            <?= ($m['status'] == 'finalizada') ? $m['gols_casa'] : '-' ?>
        </div>
        <div class="score">
            <?= ($m['status'] == 'finalizada') ? $m['gols_fora'] : '-' ?>
        </div>
        <div class="team">
            <?= $m['time_fora'] ?>
        </div>
        <div class="date">
            <?= ($m['status'] == 'finalizada') ? date('D, d/m', strtotime($m['data_jogo'])) : 'Por jogar' ?>
        </div>
    </div>
<?php
endforeach;
?>
</body>
</html>
