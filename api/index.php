<?php
header('Content-Type: application/json');

try {
    // Připojení k databázi
    $dbPath = '../db/database.sqlite';
    $dbExists = file_exists($dbPath);
    $db = new PDO('sqlite:' . $dbPath);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vytvoření databázových tabulek, pokud neexistují
    if (!$dbExists) {
        $db->exec("
            CREATE TABLE IF NOT EXISTS games (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                status TEXT NOT NULL DEFAULT 'ongoing',
                winner TEXT DEFAULT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS moves (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                game_id INTEGER NOT NULL,
                player TEXT NOT NULL,
                row INTEGER NOT NULL,
                col INTEGER NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (game_id) REFERENCES games (id)
            );
        ");
    }

    // Zpracování požadavků
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['action']) && $data['action'] === 'move') {
            $gameId = $data['game_id'];
            $player = $data['player'];
            $row = $data['row'];
            $col = $data['col'];

            $stmt = $db->prepare("SELECT * FROM moves WHERE game_id = ? AND row = ? AND col = ?");
            $stmt->execute([$gameId, $row, $col]);
            if ($stmt->fetch()) {
                echo json_encode(["status" => "error", "message" => "Pozice je již obsazena."]);
                exit;
            }

            $stmt = $db->prepare("INSERT INTO moves (game_id, player, row, col) VALUES (?, ?, ?, ?)");
            $stmt->execute([$gameId, $player, $row, $col]);

            echo json_encode(["status" => "success", "message" => "Tah byl uložen."]);
        } elseif (isset($data['action']) && $data['action'] === 'start_game') {
            $stmt = $db->prepare("INSERT INTO games (status) VALUES ('ongoing')");
            $stmt->execute();

            echo json_encode(["status" => "success", "game_id" => $db->lastInsertId()]);
        }
    } elseif ($method === 'GET') {
        if (isset($_GET['game_id'])) {
            $gameId = $_GET['game_id'];

            $stmt = $db->prepare("SELECT * FROM moves WHERE game_id = ?");
            $stmt->execute([$gameId]);
            $moves = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(["status" => "success", "moves" => $moves]);
        } else {
            echo json_encode(["status" => "error", "message" => "Chybí game_id."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Nepodporovaná metoda."]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
