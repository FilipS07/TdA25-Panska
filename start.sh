#!/bin/bash

# Kontrola a inicializace SQLite databáze
if [ ! -f /var/www/html/db/database.sqlite ]; then
    echo "SQLite databáze neexistuje, vytvářím novou..."
    sqlite3 /var/www/html/db/database.sqlite <<EOF
CREATE TABLE IF NOT EXISTS games (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    player1 TEXT NOT NULL,
    player2 TEXT NOT NULL,
    state TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
EOF
    echo "SQLite databáze byla úspěšně vytvořena."
else
    echo "SQLite databáze již existuje."
fi

# Spuštění Apache serveru
echo "Spouštím Apache server..."
apache2-foreground
