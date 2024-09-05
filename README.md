# Diego Demo App 

## Installation

```bash
$ composer install
```

Create a `.env.local` file (do not commit this file) in the root directory and set the database connection in it. An example of .env.local content:


For database in Docker run following commands in docker directory:

```bash
$ docker build -t diego_demo_mysql .
$ docker run --name diego_demo_mysql -d -p 3306:3306 diego_demo_mysql
```

Then set DATABASE_URL:
```
DATABASE_URL="mysql://root:diego-demo@127.0.0.1:3306/diego_demo"
```

If you want to use your own MySQL use following:

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

The admin panel can be accessed at `/admin`.

## Test Setup

### Create a Test Database
Create a database with the suffix `_test`. For example, if your main database is named `diego`, create a database named `diego_test`.

### Set Up a Test Domain
Set up a test domain, for example `diego.test`. This domain will be used to run the test version of your website (e.g., https://diego.test).

### Configure the Test Environment
Create a `.env.test.local` file in the root directory (do not commit this file) with the following content:

```
APP_HOST="diego.test"
DATABASE_URL="mysql://[DB_USER]:[DB_PASSWORD]@127.0.0.1:3306/[DB_NAME]?serverVersion=10.4.24-MariaDB&charset=utf8mb4"
```

**Note:** Symfony automatically appends the `_test` suffix to the `DB_NAME` specified in `.env.test.local`. Therefore, if your test database is `diego_test`, set `DB_NAME` to `diego` in the configuration.

### Import the Database Schema
```bash
$ php bin/console --env=test doctrine:schema:create
```

### Load Test Fixtures
```bash
$ php bin/console --env=test doctrine:fixtures:load --group=test
```
**Note:** Be sure to include the `--group=test` flag.

### Set the Server to Run in the Test Environment
Set the `APP_ENV` environment variable to `test` for the appropriate webserver host. For example, in Apache, you can do it like this:
```apacheconf
<VirtualHost 192.168.1.37:443>
    ...
    SetEnv APP_ENV test
    ...
</VirtualHost>
```

This ensures that the website under this domain runs in the test environment.

### Run the Tests
```bash
$ php bin/phpunit
```

### Run Phpstan
```bash
$ php vendor/bin/phpstan analyse src tests
```