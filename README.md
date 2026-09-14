# Expense Tracker

A personal finance management application built with Laravel 12. This project helps users record income and expenses, categorize transactions, set monthly budgets, track savings goals, and review financial performance through a dashboard.

## Overview

Expense Tracker is a web application designed to make it easier for users to:

- Record money coming in and going out
- Categorize transactions by type
- Set budget limits by category
- Manage personal savings goals
- Evaluate financial performance through the dashboard
- Export transaction data to PDF and Excel formats

## Key Features

- Monthly financial analysis dashboard
- Transaction list with search and filtering
- Income and expense category management
- Budget system by category for weekly/monthly planning
- Notifications when spending approaches or exceeds the budget limit
- Savings goals with accumulated totals
- Export transactions to PDF and Excel
- User authentication with Laravel Breeze

## Technologies Used

- PHP 8.2
- Laravel 12
- MySQL / default Laravel database support
- Laravel Breeze
- Blade templating
- Tailwind CSS
- DOMPDF for PDF export
- Maatwebsite Excel for Excel export
- Vite for frontend assets

## Project Structure

```bash
app/
  Http/Controllers/
  Models/
  Notifications/
config/
database/
  migrations/
  seeders/
public/
resources/
  css/
  js/
  views/
routes/
storage/
tests/
```

## Main Modules

### 1. Dashboard
The dashboard provides a summary of financial activity such as:

- current month income
- current month expenses
- current balance
- comparison with the previous month
- 6-month trend line
- expenses by category
- recent transactions
- budget alerts

### 2. Transactions
Users can add, update, and delete transactions. Each transaction includes:

- category
- amount
- description
- date
- type: income or expense

### 3. Categories
Categories are grouped by transaction type to keep the data organized and consistent.

### 4. Budgets
Users can set monthly budget limits for specific categories. The system calculates usage and sends alerts when spending is near or above the limit.

### 5. Savings Goals
The application allows users to create savings goals and contribute amounts gradually until the target is reached.

### 6. Export
Transaction data can be exported to:

- PDF
- Excel

## Project Setup

### Requirements

- PHP 8.2+
- Composer
- Node.js and npm
- Database server (for example, MySQL)

### Setup Steps

1. Clone the repository

```bash
git clone <repo-url>
cd expense-tracker
```

2. Install PHP dependencies

```bash
composer install
```

3. Copy the environment configuration file

```bash
cp .env.example .env
```

4. Generate the application key

```bash
php artisan key:generate
```

5. Configure the database in the `.env` file

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=expense_tracker
DB_USERNAME=root
DB_PASSWORD=
```

6. Run migrations

```bash
php artisan migrate
```

7. Install frontend dependencies

```bash
npm install
```

8. Run the application

```bash
npm run dev
```

Or run the Laravel server separately:

```bash
php artisan serve
```

## Useful Commands

```bash
php artisan migrate
php artisan test
php artisan route:list
php artisan make:model ModelName -m
```

## Setup Script

This project uses the `composer setup` script to make the initial setup easier:

```bash
composer run setup
```

This script will:

- install Composer dependencies
- copy `.env` if it does not exist
- generate the app key
- run migrations
- install npm dependencies
- build frontend assets

## Notes

This project is a personal finance application focused on simple, clear money management and useful results for everyday users.

## License

This project is licensed under the MIT license.
