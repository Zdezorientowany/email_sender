# Email Sender Application

This is a simple PHP application built with Symfony that sends emails to categorized users. The application is containerized using Docker.

## Prerequisites

Before you begin, ensure you have met the following requirements:

- Docker and Docker Compose installed on your local machine.
- PHP 8.x installed locally (optional, if not using Docker).

## Setup Instructions

Follow these steps to set up the project locally:

### 1. Clone the repository

```bash
git clone <repository-url>
cd <repository-directory>
```

### 2. Set up environment variables

Copy the .env.example file to .env and adjust the environment variables as necessary:

```bash
cp .env.example .env
```

### 3. Build and start Docker containers

Use Docker Compose to build and start the necessary containers:

```bash
docker-compose up -d --build
```

### 4. Install dependencies

Install the PHP dependencies using Composer:

```bash
docker-compose exec php composer install
```

### 5. Run database migrations

Generate and apply the database migrations to set up the database schema:

```bash
docker-compose exec php bin/console doctrine:database:create
docker-compose exec php bin/console doctrine:migrations:diff
docker-compose exec php bin/console doctrine:migrations:migrate
```

### 6. Load data fixtures

Load the data fixtures to populate the database with test data:

```bash
docker-compose exec php bin/console doctrine:fixtures:load
```

### 7. Running Messenger Workers

To process email sending and other queued tasks, you need to run the Messenger workers. You can start the workers with the following command:

```bash
docker-compose exec php bin/console messenger:consume async
```

### 8. Start the application

The application is served by Nginx and will automatically start when you bring up the Docker containers.
The application should now be accessible at http://localhost:8000.

### 9. Stopping the application

To stop the Docker containers, use:

```bash
docker-compose down
```

After completing the steps above, your application should be fully set up and ready to use.

## Development

### Symfony Console Alias

For convenience, a local alias ./console has been created to simplify running Symfony commands.
So instead:

```bash
docker-compose exec php bin/console <command>
```

you can use:

```bash
./console <command>
```

### Access phpMyAdmin

phpMyAdmin is available for database management at:

```bash
http://localhost:8080
```

Login and Password are 'root'

### Access Mailpit

Mailpit is available for viewing and managing emails sent during development at:

```bash
http://localhost:8025
```

All outgoing emails during development are captured by Mailpit, allowing you to inspect them without actually sending emails to real addresses.

## Test Environment Setup

### 1. Create the Test Database

First, create the test database:

```bash
docker-compose exec php bin/console doctrine:database:create --env=test
```

### 2. Run Database Migrations

Apply the database migrations for the test environment:

```bash
docker-compose exec php bin/console doctrine:migrations:migrate --env=test
```

### 3. Load Data Fixtures

If you need to seed the test database with data, load the fixtures:

```bash
docker-compose exec php bin/console doctrine:fixtures:load --env=test
```

### 4. Update the .env.test File

Ensure your .env.test file is correctly configured. Here is an example:

```bash
# .env.test
APP_ENV=test
APP_SECRET=your_secret_key
DATABASE_URL=mysql://root:root@mysql:3306/symfony
MAILER_DSN=smtp://mailpit:1025
MESSENGER_TRANSPORT_DSN=doctrine://default?auto_setup=0
```

### 5. Running Tests

To run the tests, use the following command:

```bash
docker-compose exec php ./vendor/bin/phpunit
```

This will execute the test suite in the context of Docker.
