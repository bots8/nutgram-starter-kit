# Nutgram Starter Kit

Start your Telegram bot development journey with this simple starter kit, designed for beginners. It offers essential tools and guidelines to easily build your first Telegram bot, making it a great choice for those looking to create a ready-to-use bot for production.

Read nutgram documentation since this starter kit using that Library as core component 

https://nutgram.dev/

## Requirements

Before you begin, ensure that you have the following requirements installed:

- PHP 8.2 or higher
- cURL extension for PHP
- MySQL Database (optional)

## Installation

1. Clone the repository to your local machine or using composer:

    ```bash
    composer create-project bots8/nutgram-starter-kit mybot
    ```

## Configuration

1. Copy the `.env.example` file and rename it to `.env`:

    ```bash
    cp .env.example .env
    ```

2. Open the `.env` file in a text editor and update the `TELEGRAM_BOT_TOKEN` with your actual bot token.

## Structure

- **app/**
  - **Middleware/**: This directory contains middleware classes for your bot application.
  - **QueryBuilder.php**: a simple query builder to interact with MySQL Database.
- **library/**: This directory can be used to store any additional libraries or utilities your bot might need. You can organize this folder based on your project's specific requirements.
- **.env.example**: This file serves as an example configuration file. It includes placeholders for environment variables that your application might need. Make a copy of this file as `.env` and fill in the actual values.
- **handler.php**: This file is an example webhook handler. You can customize this file to handle incoming updates from Telegram.
- **index.php**: The main entry point of your bot. You may include your application logic or use it to bootstrap your bot.
- **setWebhook.php**: A script to set up the Telegram webhook. Replace placeholders with your actual values before running this script.


## Usage

1. For production release, run the `webhook.php` script to set up your webhook:

    ```bash
    php webhook.php set
    ```

2. Start your bot application:

    ```bash
    php index.php
    ```
    
3. Or if you want to remove webhhok:

    ```bash
    php webhook.php delete
    ```

## Working with Database

You can easily interact with database but for now you can only working with MySQL Database, here a few example code to use query builder

```php
use App\QueryBuilder;

$qb = new QueryBuilder();


// Select first data
$res = $qb->table('users')
    ->select('id')
    ->where('username', '=', $username)
    ->first();

// Select all data
$res = $qb->table('users')
    ->select('*')
    ->where('id', '>', 10)
    ->findAll();

// Select by PK
$res = $qb->table('users')
    ->findByPk(1);

// Insert data
$qb->table('users')->insert([
    'telegramId' => $from->id,
    'username' => $from->username,
    'name' => $from->first_name.' '.$from->last_name,
]);

// Update data
$qb->table('users')
    ->where('username', 'user')
    ->update([
        'name' => $from->first_name,
    ]);

// Delete data
$qb->table('users')
    ->where('status', '=', 'Banned')
    ->delete();

```

## License

This Nutgram Starter Kit is open-sourced software licensed under the [MIT license](LICENSE).

Feel free to customize, extend, and share your bot based on this starter kit. Happy coding!