
# Umrah Voyage

<p align="center">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

## About The Project

**Umrah Voyage** is a comprehensive management system for travel agencies specializing in Umrah pilgrimages. It streamlines the process of managing pilgrims, bookings, packages, and logistics, ensuring a smooth experience for both the agency and the pilgrims.

---

## 📊 System Diagrams

### Activity Diagram
![Activity Diagram](activity.diagrame.umrah.png)

### Class Diagram
![Class Diagram](class.diagrame.umrah.png)

### Sequence Diagram
![Sequence Diagram](sequence.diagram.umrah.png)

---

## ✨ Key Features

- **Pilgrim Management**: Detailed profiles, passport info, and family relationships.
- **Package Management**: Create/manage packages linked to events, hotels, and transport.
- **Booking System**: Reservation system for pilgrims, room allocation, and event registration.
- **Logistics**: Manage hotels, rooms, and transport providers.
- **Alert System**: Automated alerts for passport expiry, payment reminders, and more.
- **Admin Dashboard**: Built with [Filament](https://filamentphp.com/) for a modern, customizable admin experience.

---

## 🛠️ Technology Stack

- **Framework**: Laravel 12
- **Admin Panel**: Filament 3
- **Frontend**: TailwindCSS 4
- **Build Tool**: Vite
- **Database**: MySQL

---

## 🚀 Getting Started

### Prerequisites

- PHP ^8.2
- Composer
- Node.js & NPM
- MySQL

### Installation Steps

1. **Clone the repository**
    ```bash
    git clone https://github.com/yourusername/wb--umrah.voyage.git
    cd wb--umrah.voyage
    ```
2. **Install PHP dependencies**
    ```bash
    composer install
    ```
3. **Install JavaScript dependencies**
    ```bash
    npm install
    ```
4. **Environment Setup**
    Copy the example environment file and configure your database credentials:
    ```bash
    cp .env.example .env
    ```
    Edit `.env` for your DB settings:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=umrah_voyage
    DB_USERNAME=root
    DB_PASSWORD=
    ```
5. **Generate Application Key**
    ```bash
    php artisan key:generate
    ```
6. **Database Migration & Seeding**
    ```bash
    php artisan migrate --seed
    ```
    *Seeds initial data: pilgrims, agents, events, hotels, transport, packages, reservations.*
7. **Build Assets**
    ```bash
    npm run build
    ```
8. **Run the Application**
    ```bash
    php artisan serve
    ```
    Visit: [http://localhost:8000](http://localhost:8000)

---

## 👤 Default Credentials

> **Admin**
> - Email: `admin@umrah.com`
> - Password: `password`

> **Agent**
> - Email: `agent@umrah.com`
> - Password: `password`

*You can change these credentials after login.*

---

## 🤝 Contributing

Contributions are welcome! Please submit a Pull Request.

---

## 📄 License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).
