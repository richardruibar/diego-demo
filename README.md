# Diego Demo App 

## Installation

```bash
$ composer install
```

Create a `.env.local` file (do not commit this file) in the root directory and set the database connection in it. An example of .env.local content:

```
APP_ENV=dev
DATABASE_URL="mysql://[DB_USER]:[DB_PASSWORD]@127.0.0.1:3306/[DB_NAME]?serverVersion=10.4.24-MariaDB&charset=utf8mb4"
```

Run the schema update and load fixtures:
```bash
$ php bin/console doctrine:schema:update --dump-sql -e dev --force
$ php bin/console doctrine:fixtures:load --group=app
```

In your web server configuration, set the DocumentRoot to the `public` directory.

The data fixtures include admin login credentials. Although it's generally insecure, this is only a demo app, so it's done this way for simplicity. The admin user login is `admin@example.com`, and the password is `123456`.

The admin panel can be accessed at `/admin/dashboard`.

## Test Setup

### Create a Test Database
Create a database with the suffix `_test`. For example, if your main database is named `diego`, create a database named `diego_test`.

### Configure the Test Environment
Create a `.env.test.local` file in the root directory (do not commit this file) with the following content:

```
DATABASE_URL="mysql://[DB_USER]:[DB_PASSWORD]@127.0.0.1:3306/[DB_NAME]?serverVersion=10.4.24-MariaDB&charset=utf8mb4"
```

**Note:** Symfony automatically appends the `_test` suffix to the `DB_NAME` specified in `.env.test.local`. Therefore, if your test database is `diego_test`, set `DB_NAME` to `diego` in the configuration.

### Import the Database Schema
```bash
$ php bin/console --env=test doctrine:schema:create
```

### Run the Tests
```bash
$ php bin/phpunit
```

### Run Phpstan
```bash
$ php vendor/bin/phpstan analyse src tests
```

### Production mode
Set `APP_ENV=prod` in `.env` or `.env.local.` Install assets:
```bash
$ php bin/console asset-map:compile
```
Run migrations:
```bash
$ php bin/console doctrine:migrations:migrate
```