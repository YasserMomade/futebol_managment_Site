<?php
// app/models/Match.php

class MatchModel {
    private $conn;
    private $table_name = "partidas";

    public $id;
    public $rodada;
    public $time_casa;
    public $time_fora;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Criar partida
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (rodada, time_casa_id, time_fora_id) 
                  VALUES (:rodada, :time_casa, :time_fora)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":rodada", $this->rodada);
        $stmt->bindParam(":time_casa", $this->time_casa);
        $stmt->bindParam(":time_fora", $this->time_fora);
        return $stmt->execute();
    }

    // Listar todas
   public function readAll() {
    $query = "SELECT 
                 m.id, 
                 m.status,
                 m.rodada, 
                 m.time_casa_id, 
                 m.time_fora_id, 
                 m.gols_casa, 
                 m.gols_fora,
                 t1.nome AS time_casa, 
                 t2.nome AS time_fora
              FROM " . $this->table_name . " m
              JOIN times t1 ON m.time_casa_id = t1.id
              JOIN times t2 ON m.time_fora_id = t2.id
              ORDER BY m.rodada, m.id";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
}

// Listar apenas partidas sem resultado registrado
public function listarSemResultado() {
    $query = "SELECT m.id, m.rodada,
                     t1.nome AS time_casa, 
                     t2.nome AS time_fora
              FROM " . $this->table_name . " m
              JOIN times t1 ON m.time_casa_id = t1.id
              JOIN times t2 ON m.time_fora_id = t2.id
              LEFT JOIN results r ON m.id = r.match_id
              WHERE r.id IS NULL
              ORDER BY m.rodada, m.id";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    // Buscar por ID
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Atualizar
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET rodada = :rodada, time_casa = :time_casa, time_fora = :time_fora 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":rodada", $this->rodada);
        $stmt->bindParam(":time_casa", $this->time_casa);
        $stmt->bindParam(":time_fora", $this->time_fora);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    // Deletar
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    // Atualizar resultado e status da partida
public function atualizarResultado($gols_casa, $gols_fora) {
    $status = 'finalizada'; 
    $query = "UPDATE " . $this->table_name . " 
              SET gols_casa = :gols_casa, 
                  gols_fora = :gols_fora, 
                  status = :status
              WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":gols_casa", $gols_casa);
    $stmt->bindParam(":gols_fora", $gols_fora);
    $stmt->bindParam(":status", $status);
    $stmt->bindParam(":id", $this->id);
    return $stmt->execute();
}

}
