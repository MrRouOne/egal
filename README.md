# Egal project

Установка проекта

    git clone https://github.com/MrRouOne/egal

Установка зависимостей

    Создайте файл .env и заполните его данными из файла .env.example
    (как в корне проекта, так и в сервисах)

    CMD:
    cd auth-service && composer update --ignore-platform-reqs && cd ..
    cd core-service && composer update --ignore-platform-reqs && cd ..

    PS:
    cd auth-service; composer update --ignore-platform-reqs; cd ..
    cd core-service; composer update --ignore-platform-reqs; cd ..

Запуск проекта

    docker-compose up -d --build

    docker exec project-core-service php artisan migrate --seed --force;
    docker exec project-auth-service php artisan migrate --seed --force