## Build project
docker compose up -d --build  
docker exec -it php-fpm composer install
cp ./src/.env.example ./src/.env
docker exec php-fpm php artisan key:generate
docker exec -it php-fpm php artisan migrate  
## Get data from api
docker exec -it php-fpm php artisan laps:fetch 9939
## Get data from DB with filters 
http://localhost:8080/api/laps/grouped?driver_numbers[]=4&driver_numbers[]=10&lap_range[]=3&lap_range[]=10&sum_time=1
## Start test with coverage
docker exec -it php-fpm php artisan test --coverage-html public/coverage
## Coverage result
http://localhost:8080/coverage/index.html
