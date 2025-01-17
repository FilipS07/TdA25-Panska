<?php
// db.php
$dsn = 'sqlite:games.db';
$db = new PDO($dsn);

function createGame() {
    global $db;
    $stmt = $db->prepare('
        CREATE TABLE IF NOT EXISTS games (
            id INTEGER PRIMARY KEY,
            state TEXT DEFAULT "unknown",
            grid TEXT DEFAULT "",
            current_player TEXT DEFAULT "cross"
        )
    ');
    $stmt->execute();
}

function createNewGame() {
    global $db;
    $stmt = $db->prepare('
        INSERT INTO games (state, grid, current_player)
        VALUES ("unknown", "", "cross")
    ');
    $stmt->execute();
    return $db->lastInsertId();
}

function getGame($gameId) {
    global $db;
    $stmt = $db->prepare('SELECT * FROM games WHERE id = :id');
    $stmt->bindParam(':id', $gameId);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateGame($gameId, $grid, $currentPlayer) {
    global $db;
    $stmt = $db->prepare('
        UPDATE games 
        SET grid = :grid, current_player = :current_player
        WHERE id = :id
    ');
    $stmt->bindParam(':grid', $grid);
    $stmt->bindParam(':current_player', $currentPlayer);
    $stmt->bindParam(':id', $gameId);
    $stmt->execute();
}

function checkWinner($grid) {
    // Zde bychom měli logiku pro kontrolu vítěze na základě stavu herní desky
    // Představíme to jednoduše jako funkci vracející "unknown" nebo vítěze ("cross" nebo "circle")
    // TODO: Implementace
    return "unknown"; // Prozatím vrací "unknown"
}
