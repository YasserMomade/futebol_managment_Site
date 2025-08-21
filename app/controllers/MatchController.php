<?php
// app/controllers/MatchController.php
require_once "../config/Database.php";
require_once "../models/Match.php";

class MatchController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Criar partida
public function create($rodada, $time_casa, $time_fora) {
    if ($time_casa == $time_fora) {
        return ["ok" => false, "mensagem" => "❌ Não é permitido criar partida com os mesmos times!"];
    }

    $match = new MatchModel($this->db);
    $match->rodada = $rodada;
    $match->time_casa = $time_casa;
    $match->time_fora = $time_fora;
    $sucesso = $match->create();

    if ($sucesso) {
        return ["ok" => true, "mensagem" => "✅ Partida registrada com sucesso!"];
    } else {
        return ["ok" => false, "mensagem" => "❌ Erro ao registrar a partida."];
    }
}


    // Listar todas partidas
    public function listar() {
        $match = new MatchModel($this->db);
        $stmt = $match->readAll();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarSemResultado() {
        $match = new MatchModel($this->db);
        $stmt = $match->listarSemResultado();
         return $stmt;
}

    // Buscar partida por id
    public function get($id) {
        $match = new MatchModel($this->db);
        $match->id = $id;
        return $match->readOne();
    }

    // Atualizar partida
    public function update($id, $rodada, $time_casa, $time_fora) {
        $match = new MatchModel($this->db);
        $match->id = $id;
        $match->rodada = $rodada;
        $match->time_casa = $time_casa;
        $match->time_fora = $time_fora;
        return $match->update();
    }

    // Deletar partida
    public function delete($id) {
        $match = new MatchModel($this->db);
        $match->id = $id;
        return $match->delete();
    }

    // Atualizar resultado da partida
public function atualizarResultado($match_id, $gols_casa, $gols_fora) {
    $match = new MatchModel($this->db);
    $match->id = $match_id;
    return $match->atualizarResultado($gols_casa, $gols_fora);
}

}
