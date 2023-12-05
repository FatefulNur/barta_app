# Barta Application

Barta is a minimal, elegant social media application with lightweight features.

## Installation
Clone the repo
```
    git clone https://github.com/FatefulNur/barta_app.git --single-branch -b assignment-9
```

## Usage

Follow the instructions
- Go to your project root.
- Open terminal and run `cd assignment-9` command.
- Run `composer install` on your cmd or terminal
- Copy `.env.example` file to `.env` on the root folder. You can type `copy .env.example .env` if using command prompt Windows or `cp .env.example .env` if using terminal, Ubuntu
- Open your `.env` file and change the database name (DB_DATABASE) to `barta`, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration.
- Run `php artisan key:generate`.
- Run `php artisan migrate --seed`.
- Run `npm run build`;
- Run `php artisan serve`.
- Go to http://127.0.0.1/ for login with credentials such as 
    - email: `admin@test.com`
    - password: `password`.
- To upload media for project.
    - Run `php artisan storage:link`.

## Project Features
- **Breeze Authentication**
- **Profile CRUD** (with profile photo)
- **Post CRUD** (with single media)
- **Comment CRUD**
