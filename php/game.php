<?php
// game.php (Frontend)
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piškvorky</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #f4f4f9;
            margin: 0;
        }
        h1 {
            margin-top: 20px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(15, 40px);
            grid-template-rows: repeat(15, 40px);
            gap: 2px;
            margin-top: 20px;
        }
        .cell {
            width: 40px;
            height: 40px;
            background-color: white;
            border: 1px solid #ddd;
            text-align: center;
            line-height: 40px;
            font-size: 20px;
            cursor: pointer;
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }
        .cell.taken {
            pointer-events: none;
        }
        #message {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>
    <h1>Piškvorky</h1>
    <div id="message">Na tahu: <img id="current-player" src="cross.png" alt="cross" width="30"></div>
    <div class="grid" id="game-grid"></div>

    <script>
        const gameId = '<?php echo isset($_GET['gameId']) ? $_GET['gameId'] : ''; ?>';
        const grid = document.getElementById('game-grid');
        const message = document.getElementById('message');
        const currentPlayerImage = document.getElementById('current-player');
        const rows = 15;
        const cols = 15;
        let currentPlayer = 'cross'; // 'cross' nebo 'circle'

        // Vytvoření herní mřížky
        for (let i = 0; i < rows * cols; i++) {
            const cell = document.createElement('div');
            cell.classList.add('cell');
            cell.dataset.index = i;
            grid.appendChild(cell);
        }

        // Kliknutí na políčko
        grid.addEventListener('click', (e) => {
            const cell = e.target;
            if (!cell.classList.contains('cell') || cell.classList.contains('taken')) return;

            // Nastavení obrázku pro hráče
            if (currentPlayer === 'cross') {
                cell.style.backgroundImage = 'url("cross.png")';
            } else {
                cell.style.backgroundImage = 'url("circle.png")';
            }
            cell.classList.add('taken');
            
            // Odeslání tahu na backend
            sendMove(cell.dataset.index, currentPlayer);

            // Změna hráče
            currentPlayer = currentPlayer === 'cross' ? 'circle' : 'cross';
            currentPlayerImage.src = currentPlayer === 'cross' ? 'cross.png' : 'circle.png';
        });

        // Napojení na backend (odeslání tahu)
        function sendMove(index, symbol) {
            fetch(`/api/index.php/${gameId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ index, symbol })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.winner) {
                    message.textContent = `Vítěz: ${data.winner}`;
                    grid.style.pointerEvents = 'none'; // Zablokování mřížky
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Načtení herního stavu
        fetch(`/api/index.php/${gameId}`)
            .then(response => response.json())
            .then(data => {
                if (data.grid) {
                    const gridState = JSON.parse(data.grid);
                    gridState.forEach((symbol, index) => {
                        if (symbol) {
                            const cell = grid.children[index];
                            cell.classList.add('taken');
                            cell.style.backgroundImage = symbol === 'cross' ? 'url("cross.png")' : 'url("circle.png")';
                        }
                    });
                }
            });
    </script>
</body>
</html>
