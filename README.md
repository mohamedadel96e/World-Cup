# Weapons Marketplace System (WW2 Simulation)

A Laravel-based weapons trading platform with multi-country support, team alliances, and currency conversion, set against the backdrop of World War II.

## Problem
In a simulated World War II environment, managing a complex, multi-national economy presents significant challenges. The system must coordinate interactions between different entities (Admins, Countries, Generals) and a central marketplace. It requires handling real-time inventory tracking, inter-country financial transactions with dynamic currency conversions, strict role-specific authorizations, supply chain logistics (Generals requesting weapons from Country command), and simulated combat interactions (bombings). The core problem is ensuring strict data consistency across complex multi-step transactions while providing a reactive, real-time interface for users.

## Architecture
- **MVC Pattern (Laravel):** The core logic is structured using the Model-View-Controller paradigm, with specialized services handling the bulk of the business logic.
- **Service Layer:** Complex domain actions, such as currency conversion (`CurrencyConversionService`) and supply request fulfillment (`SupplyRequestService`), are extracted into dedicated service classes to keep controllers lean.
- **Frontend Architecture:** The UI utilizes Livewire 3 and Volt for reactive components directly within Laravel, bridging the backend state and frontend representation seamlessly without a decoupled API.
- **Event-Driven Elements:** Actions like bombings and supply request processing trigger database transactions and generate subsequent notifications/emails.
- **Role-Based Access Control (RBAC):** Strict middleware (`EnsureUserHasRole`) and Eloquent Policies dictate what actions Admins (High Command), Countries (National Command), and Generals (Field Command) can perform.

## Technology choices
- **Laravel 12 / PHP 8.4:** Provides a robust ecosystem, excellent ORM (Eloquent), and built-in features (Auth, Mail, Queues, Cache).
- **Livewire 3 & Volt:** Enables building dynamic, single-page application (SPA) like experiences using PHP, reducing the cognitive load of managing a separate frontend framework (like React or Vue) and maintaining an API layer.
- **Tailwind CSS:** For rapid, utility-first, responsive UI styling.
- **SQLite / MySQL:** SQLite is used for rapid local development, while MySQL/PostgreSQL can be used for production deployment.
- **Cloudinary:** Used for robust image storage and delivery (user profiles, weapon images, flags), avoiding local filesystem constraints.
- **ExchangeRate-API:** Provides real-time currency conversion rates essential for international trade simulation.
- **Endroid QR Code:** Generates QR codes for supply request receipts and transaction verification.

## Trade-offs
- **Livewire vs. SPA (React/Vue):** Livewire simplifies development by keeping everything in PHP and avoiding API creation, but it relies on frequent AJAX requests to the server for UI updates. In a high-latency environment, this can feel slower than a purely client-side SPA.
- **Synchronous Mail Sending:** The current implementation sends the supply request receipt email synchronously during the HTTP request. This provides immediate logical flow but ties up the server and delays the HTTP response to the user. Moving this to a background queue would improve response times.
- **Caching Currency Rates vs. Real-Time:** Currency rates are cached for 24 hours. This greatly reduces API calls and speeds up page loads, but means the application might not always use the exact real-time rate. While this would be a critical issue in a real financial app, it is an acceptable trade-off for performance in a simulation.

## Failure scenarios
- **External API Outages:** If the ExchangeRate-API is unreachable and the 24-hour cache has expired, the marketplace pricing calculation fails. This will prevent users from completing weapon purchases until the API returns.
- **Mail Server Failure:** Because emails are sent synchronously, if the SMTP server fails, it throws an exception. This could cause a 500 error on the frontend, even if the database transaction (deducting funds, adding inventory) has already succeeded.
- **Race Conditions:** High concurrency of Generals buying the exact same limited-stock weapon simultaneously could theoretically lead to negative stock if not handled with strict database locks, although Laravel's atomic `decrement`/`increment` database operations mitigate much of this risk.

## Performance
- **Caching:** The `CurrencyConversionService` heavily relies on caching (`Cache::remember`) to ensure the marketplace loads instantly without waiting for an external HTTP request for every weapon's price conversion.
- **Asset Offloading:** Using Cloudinary offloads image serving, which significantly reduces bandwidth usage and concurrent connection load on the application server.
- **Database Query Optimization:** Critical relationships need proper eager loading (`with()`) to prevent N+1 query problems in the marketplace and inventory views.

## How to run it

### Prerequisites
- PHP >= 8.4
- Composer
- Node.js & NPM
- A local database (e.g., SQLite, MySQL)
- A Cloudinary account
- An ExchangeRate-API account

### Installation
1.  **Clone the repository:**
    ```bash
    git clone https://github.com/mohamedadel96e/World-Cup.git
    cd World-Cup
    ```
2.  **Install dependencies:**
    ```bash
    composer install
    npm install && npm run dev
    ```
3.  **Set up your environment file:**
    -   Copy the example environment file: `cp .env.example .env`
    -   Generate an application key: `php artisan key:generate`
    -   Update your `.env` file with your database credentials (default is usually SQLite).
4.  **Configure API Keys:**
    Add your API keys to the `.env` file:
    ```env
    CLOUDINARY_CLOUD_NAME=your_cloud_name
    CLOUDINARY_API_KEY=your_api_key
    CLOUDINARY_API_SECRET=your_api_secret

    EXCHANGE_RATE_API_KEY=your_api_key
    ```
5.  **Run database migrations and seeders:**
    This command will create all necessary tables and populate them with initial data (teams, countries, categories, weapons, users, etc.).
    ```bash
    php artisan migrate:refresh --seed
    ```
6.  **Create the storage link:**
    ```bash
    php artisan storage:link
    ```
7.  **Start the local server:**
    ```bash
    php artisan serve
    ```
    You can now access the application at `http://127.0.0.1:8000`.

### Admin Credentials
The database seeder creates a default admin user for you to log in with:
-   **Email:** `admin@example.com`
-   **Password:** `password`

## What I learned
- **Handling Complex Transactions:** Managing atomic database operations using `DB::transaction`, where multiple balances, stock levels, and user inventories must update simultaneously without data corruption.
- **Service Object Pattern:** Keeping controllers clean and testable by offloading the heavy lifting of calculating costs, verifying stock, and sending emails into dedicated service classes.
- **External API Integration:** Using Laravel's HTTP facade and Cache facade together to reliably and performantly consume third-party data while avoiding rate limits.
- **Advanced Eloquent:** Working with complex many-to-many relationships and manipulating pivot tables (e.g., `updateExistingPivot`) for detailed inventory tracking.
- **Livewire & Volt:** Building interactive, stateful UI components directly in PHP, managing state across requests without relying on a decoupled JavaScript SPA.

## Screenshots

![image-00](Assets/image-00.png)
![image-01](Assets/image-01.png)
![image-02](Assets/image-02.png)
![image-03](Assets/image-03.png)
![image-04](Assets/image-04.png)
![image-05](Assets/image-05.png)
![image-06](Assets/image-06.png)
![image-07](Assets/image-07.png)
![image-08](Assets/image-08.png)
![image-09](Assets/image-09.png)
![image-10](Assets/image-10.png)
![image-11](Assets/image-11.png)
![image-12](Assets/image-12.png)
![image-13](Assets/image-13.png)
![image-14](Assets/image-14.png)
![image-15](Assets/image-15.png)
![image-16](Assets/image-16.png)
![image-17](Assets/image-17.png)
![image-18](Assets/image-18.png)
![image-20](Assets/image-20.png)
