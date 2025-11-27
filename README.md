# Umrah Voyage

<p align="center">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

## About The Project

**Umrah Voyage** is a comprehensive management system designed for travel agencies specializing in Umrah pilgrimages. It streamlines the entire process of managing pilgrims, bookings, packages, and logistics, ensuring a smooth experience for both the agency and the pilgrims.

### Key Features

*   **Pilgrim Management**: detailed profiles including personal information, passport details, and family relationships.
*   **Package Management**: Create and manage travel packages linking events, hotels, and transportation.
*   **Booking System**: Efficient reservation system for pilgrims, handling room allocation and event registration.
*   **Logistics**: Manage hotels, rooms, and transportation providers (flights, buses, trains).
*   **Alert System**: Automated alerts for passport expirations, payment reminders, and other critical notifications.
*   **Admin Dashboard**: Built with [Filament](https://filamentphp.com/) for a robust and user-friendly administration interface.

## Technology Stack

This project is built using modern web technologies:

*   **Framework**: [Laravel 12](https://laravel.com)
*   **Admin Panel**: [Filament 3](https://filamentphp.com)
*   **Frontend Styling**: [TailwindCSS 4](https://tailwindcss.com)
*   **Build Tool**: [Vite](https://vitejs.dev)
*   **Database**: MySQL

## Architecture

The project follows a structured architecture to handle complex relationships between pilgrims, bookings, and travel components.

*   **Class Diagram**: See [class.diagram.uml](class.diagram.uml) for the data model.
*   **Activity Diagram**: See [activity.diagram.uml](activity.diagram.uml) for the booking workflow.

## Getting Started

Follow these steps to set up the project locally.

### Prerequisites

*   PHP ^8.2
*   Composer
*   Node.js & NPM
*   MySQL

### Installation

1.  **Clone the repository**
    ```bash
    git clone https://github.com/yourusername/wb--umrah.voyage.git
    cd wb--umrah.voyage
    ```

2.  **Install PHP dependencies**
    ```bash
    composer install
    ```

3.  **Install JavaScript dependencies**
    ```bash
    npm install
    ```

4.  **Environment Setup**
    Copy the example environment file and configure your database credentials.
    ```bash
    cp .env.example .env
    ```
    Update `.env` with your database settings:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=umrah_voyage
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

6.  **Database Migration & Seeding**
    Run migrations and seed the database with initial data (including test users and packages).
    ```bash
    php artisan migrate --seed
    ```
    *Note: This runs `DatabaseSeeder`, which populates pilgrims, agents, events, hotels, transport, packages, and reservations.*

7.  **Build Assets**
    ```bash
    npm run build
    ```

8.  **Run the Application**
    Start the local development server.
    ```bash
    php artisan serve
    ```
    Access the application at `http://localhost:8000`.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
