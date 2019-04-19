# AGAPE


## Installation

 * Clone code from Github
 * Copy `.env.example` to `.env` and set your database and mailer configuration
 * `composer install --no-dev --optimize-autoloader` to install PHP dependencies
 * `npm install --only=production` to install CSS & JS dependencies
 * `npm run production` to build front-end assets
 * `php artisan key:generate` to generate the application secret key
 * `php artisan config:cache` to cache the configuration (repeat if you change a setting in .env)
 * `php artisan route:cache` to cache the routes (skip if you use closure routes)
 * `php artisan migrate` to apply the database migrations
 * Configure your administator user in `database/seeds/DatabaseSeeder.php`
 * `php artisan db:seed` to seed the database with the settings and an admin user
