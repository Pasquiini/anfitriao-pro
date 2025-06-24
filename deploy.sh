#!/bin/bash
set -e

# Espera o banco de dados ficar pronto
echo "Iniciando script de deploy..."
while ! nc -z $DB_HOST $DB_PORT; do
  echo "Aguardando o banco de dados em $DB_HOST:$DB_PORT..."
  sleep 2
done

echo "Banco de dados pronto!"

# Roda os comandos do Laravel
php artisan config:clear
php artisan migrate --force

echo "Deploy finalizado com sucesso!"
