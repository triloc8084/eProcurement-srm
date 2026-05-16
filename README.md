# E-Procurement & Supplier Relationship Management (SRM) System

A full-stack web application built with **Laravel 12**, **Tailwind CSS**, and **Alpine.js** to streamline procurement processes and manage supplier relationships.

## 🚀 Features

### Admin Portal
- **Dashboard**: Overview of system activity and metrics.
- **Supplier Management**: Create, update, and manage supplier profiles.
- **Procurement Management**: Track and manage procurement requests.
- **Knowledge Base**: Manage documentation and resources.
- **Reports**: Export supplier and procurement data.
- **Settings**: System configuration.

### User Portal
- **Dashboard**: Personalized overview of requests and notifications.
- **Suppliers**: Browse and view supplier details.
- **Procurement Requests**: Create and track requests, including rating and signing.
- **Knowledge Base**: Access documentation and resources.

### Shared Features
- **Real-time Notifications**: Polling system for notifications.
- **Messaging**: Communication within procurement requests.
- **Profile Management**: Update user profile and security settings.

## 🛠 Tech Stack
- **Backend**: Laravel 12
- **Frontend**: Tailwind CSS, Alpine.js, Vite
- **Database**: MySQL (supported via standard Laravel migrations)

## ⚙️ Installation & Setup

1. **Clone the repository**:
   ```bash
   git clone <repository-url>
   cd eprocurement-srm
   ```

2. **Run Setup**:
   The project includes a custom composer script to handle installation, environment file creation, key generation, migrations, and asset building.
   ```bash
   composer setup
   ```

3. **Configure Environment**:
   Ensure your `.env` file is properly configured with your database credentials and other settings.

## 🏃‍♂️ Running the Application

To start the development server, queue listener, logs, and Vite dev server concurrently, run:
```bash
composer dev
```

The application will be accessible at `http://localhost:8000` (or the port specified by artisan serve).

## 📄 License
This project is based on the Laravel framework, which is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
