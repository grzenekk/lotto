#!/bin/bash

# Change to the project directory
cd "${0%/*}" || exit
cd ..

winpty docker-compose exec -u www-data php composer install --no-interaction --prefer-dist --optimize-autoloader
winpty docker-compose exec php php artisan migrate --force

winpty docker-compose exec -ti scheduler php /var/www/html/artisan schedule:work --verbose --no-interaction
