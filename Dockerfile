# Použití PHP 8.1 s Apache jako základní image
FROM php:8.1-apache

# Nastavení pracovního adresáře
WORKDIR /var/www/html

# Instalace systémových závislostí a MariaDB
RUN apt-get update && \
    apt-get install -y mariadb-server && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Povolení Apache mod_rewrite
RUN a2enmod rewrite

# Kopírování aplikace (pokud máte soubory přímo v kořenovém adresáři nebo ve složce php)
COPY ./ /var/www/html/

# Kopírování databázového souboru, pokud ho máte ve správné cestě
COPY ./db/database.sql /app/database.sql

# Kopírování startovacího skriptu (ujistěte se, že máte tento skript ve správné cestě)
COPY ./start.sh /start.sh
RUN chmod +x /start.sh

# Konfigurace Apache
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html\n\
    ServerName localhost\n\
    <Directory /var/www/html>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Vystavení portu 80
EXPOSE 80

# Spuštění startovacího skriptu
ENTRYPOINT ["/start.sh"]
