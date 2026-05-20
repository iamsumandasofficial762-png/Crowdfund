# Production Performance Checklist

Run these only during deployment, after `.env` is set for production.

```bash
composer install --optimize-autoloader --no-dev
npm ci
npm run build
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

Production `.env` should include:

```dotenv
APP_ENV=production
APP_DEBUG=false
```

After changing routes, config, events, or Blade templates in production, rebuild the relevant cache.
