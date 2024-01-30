# Nutgram Starter Kit

Start your Telegram bot development journey with this simple starter kit, designed for beginners. It offers essential tools and guidelines to easily build your first Telegram bot, making it a great choice for those looking to create a ready-to-use bot for production.

Read nutgram documentation since this starter kit using that Library as core component (version 3.x)

https://nutgram.dev/

## Main Features

- Well-structured folder
- Ease database integration
- CLI for development
- Testing kit (Pest)
- Ready for production

## Requirements

Before you begin, ensure that you have the following requirements installed:

- PHP 8.1 or higher
- cURL extension for PHP
- Database (optional)

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

2. Open the `.env` file in a text editor and update the `BOT_TOKEN` with your actual bot token.

## Structure

- **app/**
  - **Commands/**: This directory contains command classes for your bot application.
  - **Conversations/**: This directory contains conversation classes for your bot application.
  - **Database/**: This directory contains database-related classes for your bot application.
  - **Middleware/**: This directory contains middleware classes for your bot application.
  - **Kernel.php**: This file is the application's console kernel, which handles command execution and provides a central location for registering all of the application's console commands and more.
- **library/**: This directory can be used to store any additional libraries or utilities your bot might need. You can organize this folder based on your project's specific requirements.
- **.env.example**: This file serves as an example configuration file. It includes placeholders for environment variables that your application might need. Make a copy of this file as `.env` and fill in the actual values.
- **bootstrap.php**: This file is added to initialize the application. It may contain any necessary setup or bootstrapping logic.
- **handler.php**: This file is an example webhook handler. You can customize this file to handle incoming updates from Telegram.
- **index.php**: The main entry point of your bot. You may include your application logic or use it to bootstrap your bot.
- **tests/**: This directory contains test scripts and suites to verify the functionality and behavior of your bot application.
- **console/**: This directory houses command-line scripts and utilities for managing and interacting with your bot application.



## Usage

1. For production release, run the `webhook` command to set up your webhook:

    ```bash
    php nutgram webhook set
    ```

2. Start your bot application:

    ```bash
    php index.php
    ```
    
3. Or if you want to remove webhhok:

    ```bash
    php nutgram webhook delete
    ```

## Working with Database

You can easily interact with database but for now you can only working with supported PDO Database, here a few example code to use query builder

```php
use App\Database\DB;

$qb = new DB();


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

// Insert data
$qb->table('users')->insert([
    'telegramId' => $from->id,
    'username' => $from->username,
    'name' => $from->first_name.' '.$from->last_name,
]);

...

```

More method like: `update($arr)`, `count()`, `delete()`, `increment($col)`

## License

This Nutgram Starter Kit is open-sourced software licensed under the [MIT license](LICENSE).

Feel free to customize, extend, and share your bot based on this starter kit. Happy coding!