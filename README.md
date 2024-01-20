# Nutgram Starter Kit

This is a simple starter kit to start your journey on building Telegram bot

## Requirements

Before you begin, ensure that you have the following requirements installed:

- PHP 8.2 or higher
- cURL extension for PHP

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

- **app/**: This directory contains your bot application logic. You can organize your code in a way that makes sense to you. For example, you might have separate files for commands, middleware, and other features.

- **app/Models/**: Using Doctrine ORM, you can locate your entity classes and mappings in this directory.

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

## Doctrine ORM Usage

We use Doctrine ORM for database interactions, you can create your entity classes and mappings in the `app/Models/` directory. Refer to the Doctrine documentation for more information on defining entities and managing your database schema.

[Read Documentation](https://www.doctrine-project.org/projects/orm.html)

## License

This Nutgram Starter Kit is open-sourced software licensed under the [MIT license](LICENSE).

Feel free to customize, extend, and share your bot based on this starter kit. Happy coding!