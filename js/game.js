const gameContainer = document.getElementById("game-container");

let currentPlayer = "✖️";
let board = Array(15).fill().map(() => Array(15).fill(null));

// Vytvoření herní plochy
for (let i = 0; i < 15; i++) {
    for (let j = 0; j < 15; j++) {
        const cell = document.createElement("div");
        cell.dataset.row = i;
        cell.dataset.col = j;

        cell.addEventListener("click", () => {
            if (!cell.textContent) {
                cell.textContent = currentPlayer;
                board[i][j] = currentPlayer;

                if (checkWinner(i, j)) {
                    alert(`${currentPlayer} vyhrál!`);
                }

                currentPlayer = currentPlayer === "✖️" ? "⭕" : "✖️";
            }
        });

        gameContainer.appendChild(cell);
    }
}

// Kontrola výhry
function checkWinner(row, col) {
    // Kontrola řádků, sloupců a diagonál...
    return false; // Prozatím prázdné
}
