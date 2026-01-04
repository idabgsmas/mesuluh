web: php artisan migrate --force && php artisan storage:link && heroku-php-apache2 public/
worker: php artisan queue:work --tries=3
scheduler: while [ true ]; do php artisan schedule:run --no-interaction & sleep 60; done