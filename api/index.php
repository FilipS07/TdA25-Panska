<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello TdA</title>
</head>
<body>
    <h1>Hello TdA</h1>
</body>
</html>

<?php
// api/index.php
require_once 'db.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uriParts = explode('/', $uri);
$gameId = isset($uriParts[3]) ? $uriParts[3] : null;

createGame(); // Vytvoření tabulky her, pokud ještě neexistuje

// Zpracování požadavků
switch ($method) {
    case 'GET':
        if ($gameId) {
            $game = getGame($gameId);
            if ($game) {
                echo json_encode($game);
            } else {
                echo json_encode(['error' => 'Game not found']);
            }
        } else {
            echo json_encode(['error' => 'Game ID is required']);
        }
        break;

    case 'POST':
        if ($gameId) {
            // Uložení tahu
            $data = json_decode(file_get_contents('php://input'), true);
            if (isset($data['index'], $data['symbol'])) {
                $game = getGame($gameId);
                if ($game) {
                    // Aktualizace herní mřížky
                    $grid = json_decode($game['grid'], true);
                    $grid[$data['index']] = $data['symbol']; // Nastavení symbolu na příslušné políčko

                    // Zkontrolovat vítěze
                    $winner = checkWinner($grid);

                    // Aktualizace herního stavu a hráče
                    $currentPlayer = ($game['current_player'] === 'cross') ? 'circle' : 'cross';
                    updateGame($gameId, json_encode($grid), $currentPlayer);

                    echo json_encode(['winner' => $winner]);
                } else {
                    echo json_encode(['error' => 'Game not found']);
                }
            } else {
                echo json_encode(['error' => 'Invalid input']);
            }
        } else {
            // Vytvoření nové hry
            $gameId = createNewGame();
            echo json_encode(['gameId' => $gameId]);
        }
        break;

    default:
        echo json_encode(['error' => 'Method not allowed']);
        break;
}
