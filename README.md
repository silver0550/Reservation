# Base repository

This skeleton is based on the Laravel Framework, which has thorough [documentation](https://laravel.com).

## Setup

To initialize the project run the `init.sh` script:
```bash
./init.sh
```
This script install dependecies via `composer`, creates a `.env` file, and sets up the app key.
In this file set all necessary configurations, like database connection settings:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<DATABASE_NAME>
DB_USERNAME=<DB_USERNAME>
DB_PASSWORD=<DB_PASSWORD>
```
## Setting up the database
After the database connection is set up correctly, migrations, and seeders can be run with the following:
```bash
php artisan migrate
```
During project development this command should be run, to update the tables.
To make a fresh migration, which drops all tables and recreate them run:
```bash
php artisan migrate:fresh
```
## Setting up the Pusher
The real-time update is an important aspect of the application. It is necessary to configure Pusher in the .env file for this.
```
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=<PUSHER_ID>
PUSHER_APP_KEY=<PUSHER_KEY>
PUSHER_APP_SECRET=<PUSHER_SECRET>
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=<PUSHER_CLUSTER>
```
To ensure proper operation, please run the
```bash
npm run dev
```

## Starting the dev server
After the initial configurations, the dev server can be started like:

```bash
php artisan serve
```
