const gameContainer = document.getElementById("game-container");

let currentPlayer = "krizek";
let board = Array(15).fill().map(() => Array(15).fill(null));

// Inicializace herní plochy
for (let i = 0; i < 15; i++) {
    for (let j = 0; j < 15; j++) {
        const cell = document.createElement("div");
        cell.dataset.row = i;
        cell.dataset.col = j;

        cell.addEventListener("click", () => {
            if (!cell.dataset.player) {
                fetch("../api/index.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        action: "move",
                        game_id: 1, // Pevně nastavené pro testování
                        player: currentPlayer,
                        row: i,
                        col: j,
                    }),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "success") {
                            cell.dataset.player = currentPlayer;
                            cell.innerHTML = currentPlayer === "krizek" 
                                ? '<img src="../public/img/krizek.svg" alt="X">'
                                : '<img src="../public/img/kolecko.svg" alt="O">';
                            currentPlayer = currentPlayer === "krizek" ? "kolecko" : "krizek";
                        } else {
                            alert(data.message);
                        }
                    });
            }
        });

        gameContainer.appendChild(cell);
    }
}
