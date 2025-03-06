# Expense Approval System

This is a Laravel-based Expense Approval System that allows users to manage expenses and their approval stages. The system includes features for creating, updating, and approving expenses, as well as managing approvers and approval stages.

## Features

-   Create, update, and delete expenses
-   Approve expenses through multiple stages
-   Manage approvers and approval stages
-   API authentication using Laravel Sanctum

## Requirements

-   PHP 8.0 or higher
-   Composer
-   MySQL or any other supported database
-   Node.js and npm (for frontend assets)

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/your-username/expense-approval.git
    cd expense-approval
    ```

2. Install dependencies:

    ```bash
    composer install
    npm install
    ```

3. Copy the [.env.example](http://_vscodecontentref_/1) file to [.env](http://_vscodecontentref_/2) and update the environment variables as needed:

    ```bash
    cp .env.example .env
    ```

4. Generate the application key:

    ```bash
    php artisan key:generate
    ```

5. Run the database migrations and seed the database:

    ```bash
    php artisan migrate --seed
    ```

6. Install Laravel Sanctum:

    ```bash
    php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
    php artisan migrate
    ```

7. Serve the application:

    ```bash
    php artisan serve
    ```

## API Endpoints

### Authentication

-   `POST /api/login`: Login and obtain an API token
-   `POST /api/logout`: Logout and invalidate the API token

### Expenses

-   `GET /api/expenses`: Get all expenses
-   `POST /api/expenses`: Create a new expense
-   `GET /api/expenses/{id}`: Get a specific expense
-   `PUT /api/expenses/{id}`: Update a specific expense
-   `DELETE /api/expenses/{id}`: Delete a specific expense
-   `PATCH /api/expense/{id}/approve`: Approve a specific expense

### Approvers

-   `POST /api/approvers`: Create a new approver

### Approval Stages

-   `POST /api/approval-stages`: Create a new approval stage
-   `PUT /api/approval-stages/{id}`: Update a specific approval stage

## Running Tests

To run the tests, use the following command:

```bash
php artisan test
```
