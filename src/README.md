## Build project
docker compose build php  
docker compose up -d  
docker exec -it php php artisan migrate  
## Get data from api
docker exec -it php php artisan laps:fetch 9939
## Get data from DB with filters 
http://localhost:8080/api/laps/grouped?driver_numbers[]=4&driver_numbers[]=10&lap_range[]=3&lap_range[]=10&sum_time=1
## Start test with coverage
docker exec -it php php artisan test --coverage-html public/coverage
## Coverage result
http://localhost:8080/coverage/index.html
