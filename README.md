This project is built using **Laravel 10.x**.

### Requirements
- PHP >= 8.1
- Composer
- MySQL

### Installation

```bash
git clone <your-repo>
cd your-project
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
