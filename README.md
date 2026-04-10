# Laravel Cafe Blog

A fully-featured blog application built with Laravel 11, dedicated to coffee culture: origins, brewing methods, tasting notes, and barista tips.

## Features

- Article management (CRUD) with categories and tags
- Rich text editor for post content
- Author profiles
- Comment system with moderation
- Full-text search across posts
- RSS feed
- SEO-friendly slugs and meta tags
- Responsive design (Tailwind CSS)
- Authentication (register, login, password reset)
- Admin dashboard

## Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18
- A database supported by Laravel (MySQL, PostgreSQL, SQLite)

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/votre-pseudo/laravel-cafe-blog.git
cd laravel-cafe-blog
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install Node dependencies

```bash
npm install
```

### 4. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` to set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cafe_blog
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run migrations and seeders

```bash
php artisan migrate --seed
```

### 6. Build assets

```bash
npm run build
```

### 7. Start the development server

```bash
php artisan serve
```

Visit [http://localhost:8000](http://localhost:8000).

## Default admin credentials (seeder)

- Email: `admin@cafeblog.com`
- Password: `password`

Change these immediately in production.

## Running tests

```bash
php artisan test
```

## Deployment

See [DEPLOYMENT.md](DEPLOYMENT.md) for production deployment instructions including queue workers, caching, and scheduled tasks.

## Contributing

Pull requests are welcome. Please read [CONTRIBUTING.md](CONTRIBUTING.md) first.

## License

This project is open-source under the [MIT License](LICENSE).
