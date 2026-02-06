# CLAUDE.md

## Project Overview

Laravel 5.5 message board application implementing CRUD operations for messages. Code comments and some UI strings are in Japanese.

## Tech Stack

- **Backend:** PHP 7.0+ / Laravel 5.5
- **Database:** MySQL (default string length set to 191 for compatibility)
- **Frontend:** Blade templates, Bootstrap 4 (CDN), Vue.js 2.5.7, Sass
- **Asset Bundler:** Laravel Mix (Webpack)
- **Forms:** LaravelCollective/Html form builder

## Project Structure

```
app/
  Http/Controllers/   # Controllers (MessagesController is the main one)
  Message.php          # Message model (title, content)
  User.php             # User model (standard Laravel auth)
config/                # Laravel configuration files
database/migrations/   # Database schema (users, password_resets, messages)
resources/
  assets/              # JS (Vue) and Sass source files
  views/               # Blade templates
    layouts/app.blade.php    # Base layout
    commons/                 # Shared partials (navbar, error_messages)
    messages/                # Message CRUD views
routes/
  web.php              # Web routes (root -> MessagesController@index)
  api.php              # API routes (default only)
tests/
  Feature/             # Feature tests
  Unit/                # Unit tests
public/                # Web root, compiled assets
```

## Common Commands

```bash
# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate
php artisan migrate

# Development
php artisan serve              # Start dev server
npm run dev                    # Build assets (dev)
npm run watch                  # Watch assets for changes
npm run prod                   # Build assets (production)

# Testing
vendor/bin/phpunit             # Run all tests
vendor/bin/phpunit tests/Feature   # Feature tests only
vendor/bin/phpunit tests/Unit      # Unit tests only

# Utilities
php artisan tinker             # Interactive REPL
```

## Architecture & Conventions

- **MVC pattern** with RESTful resource controllers
- **Routes:** `Route::resource('messages', 'MessagesController')` provides full CRUD; root `/` maps to `MessagesController@index`
- **Validation:** Done inline in controller methods using `$this->validate()` (not Form Request classes)
- **Redirects:** Create/update/destroy actions redirect to the index page
- **Views:** Use Blade `@extends('layouts.app')` / `@yield('content')` inheritance pattern
- **Forms:** Built with `Form::model()`, `Form::text()`, etc. from LaravelCollective
- **Naming:** Controllers are PascalCase, models are singular PascalCase, methods are camelCase

## Database Schema

- **users** - id, name, email (unique), password, remember_token, timestamps
- **password_resets** - email, token, created_at
- **messages** - id, title (max 191), content (max 256), timestamps

## Key Files

| File | Purpose |
|------|---------|
| `app/Http/Controllers/MessagesController.php` | Main CRUD controller |
| `app/Message.php` | Message Eloquent model |
| `routes/web.php` | Route definitions |
| `resources/views/layouts/app.blade.php` | Base HTML layout |
| `resources/views/messages/` | Message view templates |
| `database/migrations/` | Schema definitions |
| `phpunit.xml` | Test configuration |
| `webpack.mix.js` | Asset compilation config |

## Testing

PHPUnit 6.0+ configured via `phpunit.xml`. Test environment uses array drivers for cache/session and sync queue driver. Tests extend `Tests\TestCase` which bootstraps the Laravel application.

## Notes

- No CI/CD pipeline configured
- No linter/formatter configuration files present; follow standard PSR-4 conventions
- No Docker setup; originally designed for Laravel Homestead
- CSRF protection enabled on all state-changing routes by default
