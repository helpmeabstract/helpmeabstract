# HelpMeAbstract.com

HelpMeAbstract connects would be speakers with veteran speakers to get feedback on their talk abstracts before submission to conferences. 

The process is simple. 
1. Go to [HelpMeAbstract.com](https://HelpMeAbstract.com)
2. Submit abstract in markdown format in a Gist Link
3. Wait for feedback from volunteer veteran speakers. 

If you'd like to volunteer you can sign up [here](https://helpmeabstract.com/volunteer)

## Local Development

* Install requirements via [composer](https://github.com/composer/composer) and `composer.json`
   * Run `composer install`
* Migrate database via [phinx](https://github.com/robmorgan/phinx) and `phinx.yml`
   * Edit `phinx.yml` and update the database settings in the `development` setting
   * Run `php vendor/bin/phinx migrate` 
* Copy `env.changeme` to `.env` (if it doesn't yet exist) and modify the database credentials
* Run this Slim-based application locally via `php -S localhost:8000 -t . index.php` from the `public/` folder
