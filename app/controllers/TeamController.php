<?php
// app/controllers/TeamController.php
require_once "../config/Database.php";
require_once "../models/Team.php";

class TeamController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Criar time
    public function create($nome) {
        $team = new Team($this->db);
        $team->nome = $nome;
        return $team->create();
    }

    // Listar todos os times
    public function listar() {
        $team = new Team($this->db);
        $stmt = $team->readAll();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar um time
    public function get($id) {
        $team = new Team($this->db);
        $team->id = $id;
        return $team->readOne();
    }

    // Atualizar time
    public function update($id, $nome) {
        $team = new Team($this->db);
        $team->id = $id;
        $team->nome = $nome;
        return $team->update();
    }

    // Deletar time
    public function delete($id) {
        $team = new Team($this->db);
        $team->id = $id;
        return $team->delete();
    }

    // listar sem rodadas
public function listarDisponiveis($rodada) {
    $sql = "
        SELECT * FROM times 
        WHERE id NOT IN (
            SELECT time_casa_id FROM partidas WHERE rodada = :rodada
            UNION
            SELECT time_fora_id FROM partidas WHERE rodada = :rodada
        )
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':rodada', $rodada);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    // ======================
    // CLASSIFICAÇÃO
    // ======================
    public function classificacao() {
        // Pega todos os times
        $teams = $this->listar();

        // Pega todos os resultados
        require_once "../controllers/ResultController.php";
        require_once "../controllers/MatchController.php";
        $resultCtrl = new ResultController();
        $matchCtrl = new MatchController();
        $matches = $matchCtrl->listar();

        // Inicializa tabela
        $tabela = [];
        foreach ($teams as $team) {
            $tabela[$team['id']] = [
                'id' => $team['id'],
                'nome' => $team['nome'],
                'jogos' => 0,
                'pontos' => 0,
                'vitorias' => 0,
                'empates' => 0,
                'derrotas' => 0,
                'gols_pro' => 0,
                'gols_contra' => 0,
                'saldo' => 0,
                'last5' => [] // aqui vamos guardar os últimos 5 resultados
            ];
        }

        // Calcula estatísticas
        foreach ($matches as $match) {
            $res = $resultCtrl->getByMatch($match['id']);
            if (!$res) continue; // se não tem resultado, pula

            $idCasa = $match['time_casa_id'];
            $idFora = $match['time_fora_id'];

            $golsCasa = $res['gols_casa'];
            $golsFora = $res['gols_fora'];

            // Incrementa jogos
            $tabela[$idCasa]['jogos'] += 1;
            $tabela[$idFora]['jogos'] += 1;

            // Gols pró / contra
            $tabela[$idCasa]['gols_pro'] += $golsCasa;
            $tabela[$idCasa]['gols_contra'] += $golsFora;

            $tabela[$idFora]['gols_pro'] += $golsFora;
            $tabela[$idFora]['gols_contra'] += $golsCasa;

            // Saldo de gols
            $tabela[$idCasa]['saldo'] = $tabela[$idCasa]['gols_pro'] - $tabela[$idCasa]['gols_contra'];
            $tabela[$idFora]['saldo'] = $tabela[$idFora]['gols_pro'] - $tabela[$idFora]['gols_contra'];

            // Pontos e vitórias/empates/derrotas
            if ($golsCasa > $golsFora) {
                $tabela[$idCasa]['vitorias'] += 1;
                $tabela[$idCasa]['pontos'] += 3;
                $tabela[$idFora]['derrotas'] += 1;

                $tabela[$idCasa]['last5'][] = "V";
                $tabela[$idFora]['last5'][] = "D";
            } elseif ($golsCasa < $golsFora) {
                $tabela[$idFora]['vitorias'] += 1;
                $tabela[$idFora]['pontos'] += 3;
                $tabela[$idCasa]['derrotas'] += 1;

                $tabela[$idFora]['last5'][] = "V";
                $tabela[$idCasa]['last5'][] = "D";
            } else {
                $tabela[$idCasa]['empates'] += 1;
                $tabela[$idCasa]['pontos'] += 1;
                $tabela[$idFora]['empates'] += 1;
                $tabela[$idFora]['pontos'] += 1;

                $tabela[$idCasa]['last5'][] = "E";
                $tabela[$idFora]['last5'][] = "E";
            }
        }

        // Mantém só os últimos 5 resultados de cada time
        foreach ($tabela as &$linha) {
            $linha['last5'] = array_slice(array_reverse($linha['last5']), 0, 5);
        }

        // Ordena por pontos e saldo
        usort($tabela, function($a, $b) {
            if ($a['pontos'] == $b['pontos']) {
                return $b['saldo'] - $a['saldo'];
            }
            return $b['pontos'] - $a['pontos'];
        });

        return $tabela;
    }
}
