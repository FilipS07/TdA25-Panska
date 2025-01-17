const gameContainer = document.getElementById("game-container");

let currentPlayer = "✖️";  // Začínáme s křížkem
let board = Array(15).fill().map(() => Array(15).fill(null));

// Vytvoření herní plochy
for (let i = 0; i < 15; i++) {
    for (let j = 0; j < 15; j++) {
        const cell = document.createElement("div");
        cell.dataset.row = i;
        cell.dataset.col = j;

        // Stylování buněk pro zobrazení obrázků
        cell.style.width = "40px"; // Můžete upravit velikost
        cell.style.height = "40px"; // Můžete upravit velikost
        cell.style.border = "1px solid #000"; // Okraje pro buňky
        cell.style.display = "inline-block";
        cell.style.cursor = "pointer";
        
        cell.addEventListener("click", () => {
            if (!cell.style.backgroundImage) { // Pokud není políčko již obsazené
                // Nastavení obrázku na základě aktuálního hráče
                if (currentPlayer === "✖️") {
                    cell.style.backgroundImage = "url('public/img/cross.svg')";
                } else {
                    cell.style.backgroundImage = "url('public/img/circle.svg')";
                }

                board[i][j] = currentPlayer;

                if (checkWinner(i, j)) {
                    alert(`${currentPlayer} vyhrál!`);
                }

                // Přepnutí hráče
                currentPlayer = currentPlayer === "✖️" ? "⭕" : "✖️";
            }
        });

        gameContainer.appendChild(cell);
    }
}

// Kontrola výhry
function checkWinner(row, col) {
    // Zde by měla být logika pro kontrolu výhry (řádky, sloupce, diagonály)
    return false; // Prozatím prázdné
}
