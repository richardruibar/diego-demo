# Diego Demo App 

## Installation

```bash
$ composer install
```

Create a `.env.local` file (do not commit this file) in the root directory and set the database connection in it. An example of .env.local content:

```
APP_ENV=dev
DATABASE_URL="mysql://root:diego-demo@127.0.0.1:3307/diego_demo?serverVersion=9.0.1&charset=utf8mb4"
```

**Note:** The setting must be the same as in the docker-compose.yml in root directory of this project.

Run docker-compose to create the database for testing and the web environment.
```bash
$ docker-compose up -d
```

Run the schema update and load fixtures:
```bash
$ php bin/console doctrine:schema:update --dump-sql -e dev --force
$ php bin/console doctrine:fixtures:load --group=app
```

**Note:** The data fixtures include admin login credentials. Although it's generally insecure, this is only a demo app, so it's done this way for simplicity. 

## Run the application

### Run the web server
```bash
$ symfony server:start
```

Visit the URL displayed by the command above. For example: https://127.0.0.1:8000/

## Admin panel
The admin panel can be accessed at `/admin/dashboard`.

The admin user login is `admin@example.com`, and the password is `123456`.

## Test Setup

### Configure the Test Environment
Create a `.env.test.local` file in the root directory (do not commit this file) with the following content:

```
DATABASE_URL="mysql://root:diego-demo@127.0.0.1:3308/diego_demo?serverVersion=9.0.1&charset=utf8mb4"
```
**Note:** The setting must be the same as in the docker-compose.yml in root directory of this project.

**Note:** Symfony automatically appends the `_test` suffix to the `DB_NAME` specified in `.env.test.local`. Therefore, if your test database is `diego_test`, set `DB_NAME` to `diego` in the configuration.

### Import the Test Database Schema
```bash
$ php bin/console --env=test doctrine:schema:create
```

### Run the Tests
```bash
$ php bin/phpunit
```

**Note**: The tests will automatically load the test data fixtures at the start.

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