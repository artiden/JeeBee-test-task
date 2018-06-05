docker-compose up app
Set value of the "ADMIN_PASSWORD_HASH" parameter into .env equal "$2y$10$kyCM8PZ1dggsQxDg1NSn0eSRdcVt5c3nEl5reVn0/8Ta4PPdFjmMa"
docker exec -it jb_php bash
composer install
vendor/bin/doctrine orm:schema-tool:create