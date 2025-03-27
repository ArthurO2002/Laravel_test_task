# Laravel & Vue.js Application

## Getting Started

Follow these steps to set up and run the Project.

### Backend (Laravel)

1. **Install dependencies:**
   ```sh
   composer install
   ```

2. **Run migrations:**
   ```sh
   php artisan migrate
   ```

3. **Start the Laravel server:**
   ```sh
   php artisan serve
   ```

### Frontend (Vue.js)

1. **Install dependencies:**
   ```sh
   npm i
   ```

2. **Run the development server:**
   ```sh
   npm run dev
   ```

## Project Structure

### Environment Configuration
The `.env` file is located at the root of the project. Ensure you update the necessary values before running the project. Below are some key variables that might need modification:

```env
APP_NAME=Laravel_test_task
APP_ENV=local
APP_KEY=base64:n+FfTLHpjt/mgTknzX6MfuGxPOqUdvHsiYRGNilRz3c=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=root

MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

VITE_APP_NAME="${APP_NAME}"
```

### Backend Structure (`app/` directory)
- **Http/Controllers** – Handles incoming requests
- **Models** – Database models
- **Providers** – Service providers
- **Services** – Business logic layer

### Frontend Structure (`resources/js` directory)
- **components/** – Vue components
- **helpers/** – Utility functions
- **store/** – Vuex/Pinia store
- **App.vue** – Root Vue component

## Notes
- Ensure you have `.env` file configured properly.
- Make sure the database is set up and running before running migrations.
- Use `php artisan key:generate` if the application key is not set.
