# Production Deployment

## Frontend build (required)

This app uses **Vite**. The built assets (`public/build/`) are not in Git, so you **must** run the frontend build on production (or build locally and upload `public/build/`).

### Option 1: Build on the server (recommended if Node.js is available)

After uploading/pulling code on the server:

```bash
# From project root (e.g. public_html or where your Laravel app lives)
npm ci
npm run build
```

This creates `public/build/manifest.json`, `public/build/assets/*.css` and `*.js`. Laravel’s `@vite()` will then load these in production.

### Option 2: Use the deploy script

If your server has Node.js and Composer:

```bash
chmod +x deploy.sh
./deploy.sh
```

This runs: `composer install --no-dev`, `npm ci`, `npm run build`, and Laravel cache commands.

### Option 3: Build locally and upload

If the server does not have Node.js:

1. On your local machine:
   ```bash
   npm ci
   npm run build
   ```
2. Upload the entire `public/build/` folder to the server at `public_html/public/build/` (or your app’s `public/build/`).

---

## Checklist

- [ ] Run `npm run build` on the server **or** upload a pre-built `public/build/` folder.
- [ ] Run `php artisan config:cache` (and other cache commands as needed).
- [ ] Ensure `APP_ENV=production` and `APP_DEBUG=false` in `.env`.

Without a production build, pages using `@vite()` may show broken or missing CSS/JS.
