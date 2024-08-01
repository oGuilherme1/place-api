# Use a imagem base do PHP 8.2 CLI
FROM php:8.2-cli

# Atualiza a lista de pacotes e instala as dependências necessárias
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
       libpq-dev \
       libonig-dev \
       unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala extensões do PHP necessárias
RUN docker-php-ext-install pdo pdo_pgsql mbstring pcntl

# Copia os arquivos do aplicativo para o contêiner
COPY . /app

# Define o diretório de trabalho como /app
WORKDIR /app

# Instalando dependências do projeto e iniciando o servidor do laravel
CMD bash -c "composer install && php artisan serve --host 0.0.0.0"