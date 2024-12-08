# Tour de App - PHP with Apache boiler plate

Šablona pro vývoj aplikace v soutěži Tour de App s čistým php a Apache webserverem

## Lokální spuštění

Prerekvizity

#### Windows

- Nainstalovaný [WSL2 (Windows Subsystem for Linux)](https://learn.microsoft.com/en-us/windows/wsl/install)
- Nainstalovaný a běžící [Docker](https://www.docker.com/)

#### Linux / MacOS

- Nainstalovaný a běžící [Docker](https://www.docker.com/)

```
    docker build . -t tda-php
    docker run -d --name tea -p 8080:80 -v "%cd%/php:/var/www/html" tda-php


```

Aplikace bude následně přístupná na `http://localhost:8080`

## Databáze

Součástí vytvořeného kontejneru je databáze běžící na portu 3306. V repozitáři naleznete soubor database.sql, jehož obsah se při vytvoření kontejneru do této databáze zkopíruje.

## Odevzdání

Jak odevzdat svojí aplikaci můžete najít v našich [vzdělávacích materiálech](https://tourde.app/vzdelavaci-materialy/jak-odevzdavat)
