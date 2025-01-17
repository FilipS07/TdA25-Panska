const gameContainer = document.getElementById("game-container");

let currentPlayer = "✖️";  // Začínáme s křížkem
let board = Array(15).fill().map(() => Array(15).fill(null));

// SVG pro křížek a kolečko
const crossSVG = '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"><line x1="0" y1="0" x2="40" y2="40" stroke="black" stroke-width="5"/><line x1="0" y1="40" x2="40" y2="0" stroke="black" stroke-width="5"/></svg>';
const circleSVG = '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"><circle cx="20" cy="20" r="15" stroke="black" stroke-width="5" fill="none"/></svg>';

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
            if (!cell.innerHTML) { // Pokud není políčko již obsazené
                // Nastavení SVG podle aktuálního hráče
                if (currentPlayer === "✖️") {
                    cell.innerHTML = crossSVG;
                } else {
                    cell.innerHTML = circleSVG;
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
