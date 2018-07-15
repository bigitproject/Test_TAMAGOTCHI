docker_name = my-php-fpm

help: #prints list of commands
	@cat ./makefile | grep : | grep -v "grep"

start: #start docker container #
	@sudo docker-compose up -d; sudo docker exec -it $(docker_name) bash -c 'npm install; npm rebuild node-sass; npm run dev; php composer.phar dump-autoload && php artisan migrate:refresh --seed;'

stop: #stop docker container
	@sudo docker-compose down