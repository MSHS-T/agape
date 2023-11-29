# AGAPE

## Presentation

This application has been developed at the request of the [MSHS-T](https://mshs.univ-toulouse.fr/) with the contribution of the [Toulouse University](https://www.univ-toulouse.fr/) to improve the management of research project calls.

## Installation

### App Setup
 * Clone code from Github
 * Copy `.env.example` to `.env` and set your configuration (see the comments for help).
 * `composer install --no-dev --optimize-autoloader` to install PHP dependencies *(remove the `--no-dev` flag if you wish to generate test data now or in the future)*
 * `npm install` to install CSS & JS dependencies
 * `npm run build` to build front-end assets
 * `php artisan key:generate` to generate the application secret key
 * `php artisan config:cache` to cache the configuration (repeat if you change a setting in .env)
 * `php artisan storage:link` to create the symbolic link to access files in public storage
 * `php artisan migrate` to apply the database migrations
 * `php artisan db:seed` to seed the database with the settings and an admin user (with the email set in `.env` and the password `password`)

If you wish to add test data, you can run the `php artisan db:seed --class="TestDataSeeder"`. The following data will be created :
 * One user for each role other than administrator (all will have the password `password`) :
   * gestionnaire@agape.fr
   * candidat@agape.fr
   * expert@agape.fr
 * 4 Project Call Types with dynamic fields (see `database/seeders/ProjectCallTypeSeeder.php`)
 * 10 fake Study Fields
 * 10 fake Laboratories
 * 5 fake Project Calls
> If running this command throws a `Class "Faker\Factory" not found` error, you forgot to remove the `--no-dev` flag from the `composer install` command above. Running it without this flag will add the developement dependencies required

### HTTP Server Configuration

The recommanded HTTP server is NGINX, using the site configuration described in [documentation](https://laravel.com/docs/10.x/deployment#nginx). If you wish to use another HTTP Server, you will have to translate this configuration into the required format.

The (recommanded) setup of an SSL certificate for HTTPS will depend on your environment. It will also require that you update the `APP_URL` environment variable in your `.env` file.

### File permissions

The following permissions are required for the HTTP Server user :
* All files : readable
* All folders : traversable
* `storage`and `bootstrap/cache` folders : writable and executable

Supposing the HTTP server user is `www-data`, the following commands set up the proper permissions on the source code while retaining ownership by the current user, making the update process easier  :
```bash
cd /path/to/project
sudo chown -R $USER:www-data .
sudo find . -type d -exec chmod 755 {} \;
sudo find . -type f -exec chmod 644 {} \;
sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache
```

## Update process

*The following script is meant to be customized to your specific requirements.*

```bash
cd /path/to/project

# Enable maintenance mode
php artisan down

# Reset local changes (build files)
git checkout -- .
# Remove the above command if you have custom changes you wish to keep.
# It may cause errors in the git pull command if conflict appears

# Fetch code
git pull

# Install dependencies (remove '--no-dev' flag if needed)
composer install --optimize-autoloader --no-dev
npm ci

# Build front-end assets
npm run build

# Migrate database
php artisan migrate --force

# Cache warmup
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Reset permissions
sudo chown -R $USER:www-data .
sudo find . -type d -exec chmod 755 {} \;
sudo find . -type f -exec chmod 644 {} \;
sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache

# Disable maintenance mode
php artisan up
```