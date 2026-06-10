# Developer Documentation: Matrimonial Laravel Project

## Project Overview
This project is a Matrimonial application built using the **Laravel Framework (v9.x)** for the backend and **Vue.js** with **Bootstrap** for the frontend. It features a comprehensive system for user profiles, matchmaking, premium packages, and payment processing.

## Technology Stack
- **Backend**: Laravel 9.2, PHP ^8.0.2
- **Frontend**: Vue.js 2.x, jQuery 3.2, Bootstrap 4.0, SCSS
- **Database**: MySQL
- **Assets Management**: Laravel Mix (Webpack)

## Prerequisites
Ensure your development environment meets the following requirements:
- **PHP**: >= 8.0.2
- **Composer**: Dependency Manager for PHP
- **Node.js & NPM**: For frontend asset compilation
- **MySQL**: Database server

## Installation & Setup

1.  **Clone the Repository**
    ```bash
    git clone <repository-url>
    cd <project-directory>
    ```

2.  **Install Backend Dependencies**
    ```bash
    composer install
    ```

3.  **Environment Configuration**
    - Copy the example environment file:
      ```bash
      cp .env.example .env
      ```
    - Update `.env` with your database credentials (DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD) and other settings.

4.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

5.  **Database Migration & Seeding**
    - Create the database specified in your `.env`.
    - Run migrations and seeds:
      ```bash
      php artisan migrate --seed
      ```
    - *Note:* There is a `matrimonial.sql` file in the root which might be a full dump. You can import that if you want a pre-populated database:
      ```bash
      mysql -u username -p database_name < matrimonial.sql
      ```

6.  **Install Frontend Dependencies**
    ```bash
    npm install
    ```

7.  **Compile Assets**
    - For development (with file watching):
      ```bash
      npm run watch
      ```
    - For production:
      ```bash
      npm run prod
      ```

8.  **Serve Application**
    ```bash
    php artisan serve
    ```
    Access the site at `http://localhost:8000`.

## Project Structure (Key Directories)

- **`app/Http/Controllers`**: Contains the core logic. Key groupings include:
    - `Auth/`: Authentication logic.
    - `Api/`: API endpoints for mobile/external usage.
    - `MemberController.php`: Manages user profiles.
    - `PackagePaymentController.php`: Handles package purchase flow.
    - `*PaymentController.php`: Specific implementation for gateways (Stripe, Paypal, Razorpay, etc.).
- **`app/Models`**: Eloquent models representing database tables (e.g., `Member`, `Package`, `HappyStory`).
- **`config/`**: Configuration files. Notable custom configs:
    - `larafirebase.php`: Firebase settings.
    - `pdf.php`: PDF generation settings.
    - `paystack.php`: Paystack payment settings.
- **`resources/views`**: Blade templates for the server-rendered UI.
- **`resources/js`**: Vue.js components and main Javascript entry points.
- **`routes`**:
    - `web.php`: Web routes.
    - `api.php`: API routes.
    - `admin.php`: Admin panel routes.

## Key Features & Integrations

### Payment Gateways
The system supports multiple payment gateways for membership packages and wallet top-ups:
- Stripe, PayPal, Razorpay, Instamojo, Paystack, Paytm.
- PhonePe, Aamarpay, SSLCommerz.
- Manual Payment methods.

### Third-Party Services
- **Social Login**: Login with Facebook, Google, Twitter, Apple (via Socialite).
- **Notifications**: Firebase (Larafirebase) and SMS gateways (Twilio).
- **PDF Generation**: `niklasravnsborg/laravel-pdf` used for generating profiles or receipts.

### Permissions
Uses `spatie/laravel-permission` for managing Roles and Permissions (Admin, Staff, Members).

## Common Tasks

- **Adding a new Payment Gateway**:
    1.  Add configuration keys to `.env` and `config/`.
    2.  Create a Controller (e.g., `NewPayController`) to handle requests/webhooks.
    3.  Add it to `PaymentTypesController` (or similar logic in `SettingController` or `PackagePaymentController`).

- **Modifying Profiles**:
    - Look into `MemberController` and `ProfileController`.
    - Related models are in `app/Models` (assumed based on standard structure).

## Deployment Tips
- Ensure `storage` and `bootstrap/cache` directories are writable (`chmod -R 775`).
- Run `composer install --optimize-autoloader --no-dev` for production.
- Run `php artisan config:cache`, `php artisan route:cache`, and `php artisan view:cache` for performance.
