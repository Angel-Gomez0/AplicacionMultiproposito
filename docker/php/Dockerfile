# ARG para la versión de PHP
ARG php_version

# Usar la imagen base de PHP con la versión proporcionada
FROM php:${php_version}

# Actualizar y preparar las dependencias necesarias
RUN apt-get update --fix-missing && \
    apt-get install -y build-essential libssl-dev zlib1g-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libmariadb-dev-compat libmariadb-dev

# Instalar las extensiones de MySQL (PDO)
RUN docker-php-ext-install mysqli pdo pdo_mysql
