# HelpMeAbstract.com

## Local Development

* Install requirements via [composer](https://github.com/composer/composer) and `composer.json`
   * Run `composer install`
* Migrate database via [phinx](https://github.com/robmorgan/phinx) and `phinx.yml`
   * Edit `phinx.yml` and update the database settings in the `development` setting
   * Run `php vendor/bin/phinx migrate` 
* Copy `env.changeme` to `.env` and modify the database credentials
* Run this Slim-based application locally via `php -S localhost:8000 -t . index.php` from the `public/` folder
