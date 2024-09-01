# Diego Demo App 

## Installation

```bash
$ composer install
```

Create a .env.local file in the root directory and set the database connection in it. An example of .env.local content:

```
APP_ENV=dev
DATABASE_URL="mysql://[DB_USER]:[DB_PASSWORD]@127.0.0.1:3306/[DB_NAME]?serverVersion=10.4.24-MariaDB&charset=utf8mb4"
```

Run the schema update and load fixtures:
```bash
$ php bin/console doctrine:schema:update --dump-sql -e dev --force
$ php bin/console doctrine:fixtures:load
```

In your web server configuration, set the DocumentRoot to the `public` directory.

The data fixtures include admin login credentials. Although it's generally insecure, this is only a demo app, so it's done this way for simplicity. The admin user login is `admin@example.com`, and the password is `123456`.

The admin panel can be accessed at `/admin`.