#!/bin/bash

docker-compose up -d --build site
docker-compose run --rm composer update
docker-compose run --rm npm i
docker-compose run --rm npm run dev
docker-compose run --rm artisan migrate
docker-compose run --rm artisan key:generate
docker-compose run --rm artisan storage:link
