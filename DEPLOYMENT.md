# Deployment Guide

## Production checklist

### Environment

```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.com
```

### Optimize for production

```bash
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
npm run build
```

### Storage

```bash
php artisan storage:link
```

### Queue worker (Supervisor recommended)

```ini
[program:cafe-blog-worker]
command=php /var/www/cafe-blog/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/log/cafe-blog-worker.log
```

### Scheduled tasks (cron)

Add to server crontab:

```cron
* * * * * cd /var/www/cafe-blog && php artisan schedule:run >> /dev/null 2>&1
```

### Nginx configuration

```nginx
server {
    listen 80;
    server_name votre-domaine.com;
    root /var/www/cafe-blog/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```
