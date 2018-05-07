# Goen

We use this web site for referrence:
Front side: http://demo.job-maker.jp/
CMS: http://demo.job-maker.jp/manage/_Login.jsp
ID：guest021
PASS：guest021

### Pre-requisites

  - PHP >= 5.6.4
  - MySQL
  - Composer
  - Node JS

### First time setup
  - copy .env file from .env.example and then change database configuration
```sh
$ cp .env.example .env
```
  - install composer modules. You'll need to run this command again if there's any update in the file composer.json
```sh
$ composer install
```
- Generate application key
```sh
$ php artisan key:generate
```
- Init database
```sh
$ php artisan migrate
$ php artisan db:seed
```
- Link storage folder
```sh
$ php artisan storage:link
```
- Update masterdata
```
$ make generate-master {lang=en}
$ make update-master {lang=en}
```

### Compiling assets
We use Laravel Mix and webpack to manage and version our assets (javascript, css). Here's how to to do it:
  - Install node modules. You only need to run this command again if there's any update in the file package.json
```sh
$ npm install
```
  - Compile assets
```sh
$ npm run dev
```
  - If you dont want to run the above command every time you update a javscript or css file, you can use the following command to watch and compile automatically
```sh
$ npm run watch
```

### Test it out
```sh
$ php artisan serve
```

### Other commands you might find usefull
- Create new table
```sh
$ php artisan make:migration create_companies_table --create=companies
```

- After add columns for generated table, you can use the following command to generate API for it
```sh
$ php artisan infyom:api Company --fromTable --tableName=companies
```

### Coding convention

- Indentation: 2 spaces for html/js and 4 spaces for php/css
- No trailing space
- Defining constants inside app/Consts.php and utility functions

- JS: `npm test`
- PHP:
  - `vendor/bin/phpcs --standard=phpcs.xml`
  - `vendor/bin/phpmd app text phpmd.xml`

### Shortcut

```shell
make init-app   # Generate app key
make init-db    # Reset databse
make start      # Start server
make log        # Tail Laravel log
make test-js    # Check standard *.js
make test-php   # Check standard *.php
make build      # Build assets (*.js, *css)
make watch      # Watch assets (*.js, *css)
make autoload   # Reload *.php
make cache      # Clear cache
make route      # List routes
```
