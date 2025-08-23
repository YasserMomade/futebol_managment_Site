<?php
// app/controllers/ResultController.php
require_once __DIR__ . "/../config/conn.php";
require_once "../models/Result.php";

class ResultController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Lançar resultado
    public function create($match_id, $gols_casa, $gols_fora) {
        $result = new Result($this->db);
        $result->match_id = $match_id;
        $result->gols_casa = $gols_casa;
        $result->gols_fora = $gols_fora;
        return $result->create();
        
    }

    // Buscar resultado por partida
    public function getByMatch($match_id) {
        $result = new Result($this->db);
        $result->match_id = $match_id;
        return $result->readByMatch();
    }

    // Atualizar resultado
    public function update($match_id, $gols_casa, $gols_fora) {
        $result = new Result($this->db);
        $result->match_id = $match_id;
        $result->gols_casa = $gols_casa;
        $result->gols_fora = $gols_fora;
        return $result->update();
    }
}
