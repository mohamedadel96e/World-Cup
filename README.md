# Weapons Marketplace System

A Laravel-based weapons trading platform with multi-country support, team alliances, and currency conversion, set against the backdrop of World War II.

---

## Features

The application is built around a robust role-based authorization system, providing a unique experience for each type of user.

### 🎖️ Admin (High Command)
The super user with global oversight of the entire operation.
- **Full CRUD Management:** Create, read, update, and delete all core models including Users, Weapons, Categories, Countries, and Teams.
- **User Role Management:** Promote or demote users between roles (Admin, Country, General).
- **Global Weapon Control:** Make weapons unavailable on the marketplace, affecting all users.
- **Economic Oversight:** View and manage the national balance of all countries.

### 🇩🇪 Country User (National Command)
Represents a specific nation and manages their national economy and arsenal.
- **Stockpile Management:** View a detailed inventory of all weapons owned by their country.
- **Manufacture Weapons:** "Manufacture" new weapons by paying the `manufacturer_price` from the national balance.
- **Marketplace Operations:** List weapons for sale, set prices, and manage discounts for allied nations.
- **Purchase Armaments:** Buy weapons from the global marketplace to bolster their stockpile.
- **Process Requisitions:** Receive and process supply requests submitted by their country's Generals.

### 👨‍✈️ General (Field Command)
Represents a general on the front lines with urgent supply needs.
- **Submit Requisitions:** Create and submit detailed supply requests for specific weapons and quantities.
- **Email & QR Code Confirmation:** Receive formatted email responses detailing the status of their request, complete with a QR code linking to a permanent transaction receipt.
- **Personal Inventory:** View a personal inventory of all weapons that have been successfully allocated to them.

---

## 🛠️ Tech Stack

- **Backend:** Laravel 12, PHP 8.4
- **Frontend:** Livewire 3 & Volt for dynamic, real-time components.
- **Styling:** Tailwind CSS for a utility-first, modern design.
- **Database:** SQLite (local), MySQL/PostgreSQL (production).

---

## API Services

- **Cloudinary**: Used for cloud-based storage and management of all image assets (user profiles, weapon images, country flags, and team logos).
- **Exchange Rate API**: Provides real-time currency exchange rates to power the dynamic pricing in the marketplace.
- **Endroid QR Code**: A robust library for generating QR codes for email-based transaction receipts and verification.

---

## 🚀 Getting Started

Follow these steps to set up the project on your local machine.

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
    git clone [https://github.com/mohamedadel96e/World-Cup.git](https://github.com/mohamedadel96e/World-Cup.git)
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
    -   Update your `.env` file with your database credentials.

4.  **Configure API Keys:**
    Add your API keys to the `.env` file:
    ```env
    # .env
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
    This makes your uploaded files publicly accessible.
    ```bash
    php artisan storage:link
    ```

7.  **Start the local server:**
    ```bash
    php artisan serve
    ```
You can now access the application at `http://127.0.0.1:8000`.

### 🔑 Admin Credentials

The database seeder creates a default admin user for you to log in with:

-   **Email:** `admin@example.com`
-   **Password:** `password`


