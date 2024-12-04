#!/bin/sh

# Start MariaDB
service mariadb start

# Wait for MariaDB to start up
sleep 5

# Create the database if it doesn't exist
echo "CREATE DATABASE IF NOT EXISTS db" | mysql

# Import the database from the .sql file
mysql db < /app/database.sql

# Start Apache in the foreground
apache2ctl -D FOREGROUND
