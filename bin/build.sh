#!/bin/bash

# Change to the project directory
cd "${0%/*}" || exit
cd ..

docker-compose exec -ti scheduler php /var/www/html/artisan schedule:work --verbose --no-interaction
docker-compose exec php php artisan migrate --force
