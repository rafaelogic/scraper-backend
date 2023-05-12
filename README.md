# Scraper Backend
A simple way to extract products from a shopify store and save it in your database.

## Stack
- Laravel
- RESTful API with Laravel Sanctum and Fortify API and SPA auth service 
- Repository Pattern
- MongoDB with laravel-mongodb package
- A Simple way and command to extract products from shopify store

## Setup

Run the commands below individually 

```bash
# Laravel Sail
php artisan sail:install

# Run Laravel Sail
./vendor/bin/sail up -d

# Install Dependencies
./vendor/bin/sail composer install

# Run Migrations
./vendor/bin/sail artisan migrate

# Seed user for testing (Needed in frontend)
./vendor/bin/sail artisan db:seed

# Run command to start extracting
./vendor/bin/sail artisan scrape:products
```

## Guide
If you haven't setup Laravel Sail with MongoDB you can check the [guide](https://rafaelogic.medium.com/setup-mongodb-in-laravel-sail-cef795e9f697) I created to successfully set it up and test this app. 
