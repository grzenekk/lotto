#!/bin/bash

# Change to the project directory
cd "${0%/*}" || exit
cd ..

docker-compose exec -u www-data php composer install --no-interaction --prefer-dist --optimize-autoloader
docker-compose exec php php artisan migrate --force

docker-compose exec -ti scheduler php /var/www/html/artisan schedule:work --verbose --no-interaction
