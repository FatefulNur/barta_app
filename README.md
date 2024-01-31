# Barta Application

Barta is a minimal, elegant social media application with beautiful features.

## Installation
Clone the repo
```
    git clone https://github.com/FatefulNur/barta_app.git --single-branch -b testing
```

## Usage

Follow the instructions
- Go to your project root.
- Open terminal and run `cd testing` command.
- Run `composer install` on your cmd or terminal
- Copy `.env.example` file to `.env` on the root folder. You can type `copy .env.example .env` if using command prompt Windows or `cp .env.example .env` if using terminal, Ubuntu
- Open your `.env` file and change the database name (DB_DATABASE) to `barta`, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration.
- Run `php artisan key:generate`.
- Run `php artisan migrate --seed`.
- To upload media for project.
    - Run `php artisan storage:link`.
- Run `npm run dev`.
- Run `php artisan serve`.
- Go to http://localhost:8000/ for login with credentials such as 
    - email: `admin@test.com`|`author@test.com`|`editor@test.com`
    - password: `password`.

## Websocket Configuration
I am using [Laravel websockets](https://beyondco.de/docs/laravel-websockets/getting-started/introduction) for this project utilizing pusher websocket connection configuration that's comes with the package. Copy the below code into your `.env` file:
```
PUSHER_APP_ID=bartaAppId
PUSHER_APP_KEY=bartaAppKey
PUSHER_APP_SECRET=bartaAppSecret
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
PUSHER_SCHEME=http
PUSHER_APP_CLUSTER=mt1
```
- Don't forget to run command: `php artisan websockets:serve`.
- Then visit http://localhost:8000/laravel-websockets.
- Make a setup of:
    - Host: `127.0.0.1`
    - Port: `6001`
- Click to the connect button.
- Wait for loading default events. 

## Mail Configuration
You can use **mailtrap** to set you email configuration testing email in this application. [Here](https://mailtrap.io/blog/send-email-in-laravel/) is the guideline of how to configure mailtrap for laravel.
After set you email server, you are now ready to test email.

As I am using mail with queue, you must be running command: `php artisan queue:work`. Otherwise the notification for comment will store into the jobs migration.

## Important
Run the following commands:
- `php artisan serve`.
- `npm run dev`.
- `php artisan websockets:serve`.
- `php artisan queue:work`.

If you are not getting realtime notification update you might miss connecting websocket in [this](http://localhost:8000/laravel-websockets) url or you may forgot to run `php artisan queue:work`.

## Testing
To run automated test of this application you may run command either:
- `.\vendor\bin\phpunit` or 
- `php artisan test`.

## Greetings
Thanks for reading.
