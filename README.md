# Docker: PHP & MySQL

Este repositorio contiene un docker con PHP y MySQL, junto con el desarrollo para el hackaton

## Requerimientos

Los participantes deberán tener una PC con al menos git para partcipar y utilizar el entorno de desarrollo, se recomienda tener Ubuntu instalado.

## Configuración del ambiente de desarrollo

* `PHP_VERSION` versión de PHP
* `PHP_PORT` puerto para servidor web.
* `MYSQL_VERSION` versión de MySQL
* `MYSQL_USER` nombre de usuario para conectarse a MySQL.
* `MYSQL_PASSWORD` clave de acceso para conectarse a MySQL.
* `MYSQL_DATABASE` nombre de la base de datos que se crea por defecto.

## Instalar el ambiente de desarrollo

La instalación se hace en línea de comandos:

```zsh
docker-compose up -d
```

## Comandos disponibles

Una vez instalado, se pueden utilizar los siguiente comandos:

```zsh
docker-compose start    # Iniciar el ambiente de desarrollo
docker-compose stop     # Detener el ambiente de desarrollo
docker-compose down     # Detener y eliminar el ambiente de desarrollo.
```

## Estructura de Archivos

* `/docker/` contiene los archivos de configuración de Docker.
* `/www/` carpeta para los archivos PHP del proyecto.

## Accesos

### Web

* http://localhost/
