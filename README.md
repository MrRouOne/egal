# Egal project

Установка проекта

    git clone https://github.com/MrRouOne/egal

Установка зависимостей

    Создайте файл .env в и заполните его данными из файла .env.example

    CMD:
    cd auth-service && composer update --ignore-platform-reqs && cd ..
    cd core-service && composer update --ignore-platform-reqs && cd ..

    PS:
    cd auth-service; composer update --ignore-platform-reqs; cd ..
    cd core-service; composer update --ignore-platform-reqs; cd ..

Запуск проекта

    docker-compose up -d --build