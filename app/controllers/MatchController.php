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
            return "Times não podem ser iguais!";
        }

        $match = new MatchModel($this->db);
        $match->rodada = $rodada;
        $match->time_casa = $time_casa;
        $match->time_fora = $time_fora;
        return $match->create();
    }

    // Listar todas partidas
    public function listar() {
        $match = new MatchModel($this->db);
        $stmt = $match->readAll();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
}
