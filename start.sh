#!/bin/sh

# Start MariaDB
service mariadb start

# Wait for MariaDB to start up
sleep 5

# Start Apache in the foreground
apache2ctl -D FOREGROUND
