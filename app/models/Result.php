<?php
// app/models/Result.php

class Result {
    private $conn;
    private $table_name = "results";

    public $id;
    public $match_id;
    public $gols_casa;
    public $gols_fora;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Criar resultado
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (match_id, gols_casa, gols_fora) 
                  VALUES (:match_id, :gols_casa, :gols_fora)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":match_id", $this->match_id);
        $stmt->bindParam(":gols_casa", $this->gols_casa);
        $stmt->bindParam(":gols_fora", $this->gols_fora);
        return $stmt->execute();
    }

    // Buscar resultado de uma partida
    public function readByMatch() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE match_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->match_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Atualizar resultado
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET gols_casa = :gols_casa, gols_fora = :gols_fora 
                  WHERE match_id = :match_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":gols_casa", $this->gols_casa);
        $stmt->bindParam(":gols_fora", $this->gols_fora);
        $stmt->bindParam(":match_id", $this->match_id);
        return $stmt->execute();
    }
}
