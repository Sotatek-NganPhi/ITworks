ifndef u
u:=sotatek
endif

ifndef env
env:=dev
endif

init-app:
	php artisan key:generate

init-db-full:
	make autoload
	php artisan migrate:refresh
	make update-master lang=$(lang)
	php artisan db:seed

init-db:
	make autoload
	php artisan migrate:refresh
	make update-master lang=$(lang)
	php artisan db:seed --class=ManagerSeeder

start:
	php artisan serve

log:
	tail -f storage/logs/laravel.log

test-js:
	npm test

test-php:
	vendor/bin/phpcs --standard=phpcs.xml && vendor/bin/phpmd app text phpmd.xml

build:
	npm run dev

watch:
	npm run watch

autoload:
	composer dump-autoload

cache:
	php artisan cache:clear && php artisan view:clear

route:
	php artisan route:list

generate-master:
	php bin/generate_master.php $(lang)

check-master:
	php bin/check_master.php $(lang)

update-master:
	php artisan master:update $(lang)

schedule-run:
	{ crontab -l; echo "* * * * * php ${shell pwd}/artisan schedule:run 1>> /dev/null 2>&1"; } | crontab -

reset-ranking:
	php artisan reset-ranking

deploy:
	ssh $(u)@$(server) "mkdir -p $(dir)"
	rsync -avhzL --delete \
				--no-perms --no-owner --no-group \
				--exclude .git \
				--exclude .idea \
				--exclude .env \
				--exclude node_modules \
				--exclude vendor \
				--exclude bootstrap/cache \
				--exclude storage/logs \
				--exclude storage/framework \
				--exclude storage/app \
				--exclude public/hot \
				--exclude public/storage \
				--exclude public/mix-manifest.json \
				--exclude public/mix.js \
				. $(u)@$(server):$(dir)/

connect-master:
	ssh root@160.16.117.169

connect-slave:
	ssh root@160.16.50.160

init-db-local:
	ssh $(u)@192.168.1.201 "cd /var/www/goen$(n)/ && make init-db-full"

deploy-local-origin:
	make deploy server=192.168.1.201 dir=/var/www/goenjp
	ssh $(u)@192.168.1.201 "cd /var/www/goenjp/ && make cache"

deploy-local:
	make deploy server=192.168.1.201 dir=/var/www/goen$(n)
	ssh $(u)@192.168.1.201 "cd /var/www/goen$(n) && make cache"

deploy-staging:
	make deploy server=160.16.117.169 u=root dir=/var/www/goen_stg
	ssh root@160.16.117.169 "cd /var/www/goen_stg/ && make cache"

deploy-production:
	make deploy server=160.16.117.169 u=root dir=/var/www/goen
	ssh root@160.16.117.169 "cd /var/www/goen/ && make cache"

compile:
	ssh $(u)@$(server) "cd $(dir) && npm install && composer install && make cache && make autoload && npm run production"

deploy-local-full:
	make deploy server=192.168.1.201 dir=/var/www/goenjp
	make compile server=192.168.1.201 dir=/var/www/goenjp

deploy-staging-full:
	make deploy server=160.16.117.169 u=root dir=/root/goenjp
	make compile server=160.16.117.169 u=root dir=/root/goenjp
	ssh root@160.16.117.169 "rsync -avhzL --delete --no-perms --no-owner --no-group \
																	--exclude .env \
																	--exclude public/storage \
																	--exclude bootstrap/cache \
																	--exclude storage/logs \
																	--exclude storage/framework \
																	--exclude storage/app \
																	/root/goenjp/* /var/www/goen_stg/"
	ssh root@160.16.117.169 "cd /var/www/goen_stg/ && make cache"

deploy-production-full:
	make deploy server=160.16.117.169 u=root dir=/root/goenjp
	make compile server=160.16.117.169 u=root dir=/root/goenjp
	ssh root@160.16.117.169 "rsync -avhzL --delete --no-perms --no-owner --no-group \
																	--exclude .env \
																	--exclude public/storage \
																	--exclude bootstrap/cache \
																	--exclude storage/logs \
																	--exclude storage/framework \
																	--exclude storage/app \
																	/root/goenjp/* /var/www/goen/"
	ssh root@160.16.117.169 "cd /var/www/goen/ && make cache"
