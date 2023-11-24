# Barta Application

Barta is a minimal, elegant social media application with lightweight features.

## Installation
Clone the repo
```
    git clone https://github.com/FatefulNur/barta_app.git --single-branch -b assignment-8
```

## Usage

Follow the instructions
- Go to your project root.
- Open terminal and run `cd 'your-project-folder'` command.
- Run `composer install` on your cmd or terminal
- Copy `.env.example` file to `.env` on the root folder. You can type `copy .env.example .env` if using command prompt Windows or `cp .env.example .env` if using terminal, Ubuntu
- Open your `.env` file and change the database name (DB_DATABASE) to `barta`, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration.
- Run `php artisan key:generate`.
- Run `php artisan migrate --seed`.
- Run `php artisan serve`.
- Go to http://localhost:8000/register and register new account.
- Go to http://localhost:8000/login to login and visit your posts.

## Project Features
- **Breeze Authentication**
- **Profile CRUD**
- **Post CRUD**
- **Comment CRUD**
