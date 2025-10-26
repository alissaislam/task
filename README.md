Installation
1. Clone the Repository
bash
git clone (https://github.com/alissaislam/task.git)
cd task-management-system

2. Install Dependencies
bash
composer install

3. Environment Configuration
bash
cp .env.example .env
php artisan key:generate

Update .env with your database credentials:

env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_management
DB_USERNAME=your_username
DB_PASSWORD=your_password

4. Database Setup
bash
php artisan migrate --seed

5. Sanctum Setup
bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate


bash
php artisan serve
Visit: http://localhost:8000


Default Users
Admin User
Email: admin@taskmanager.com

Password: admin123

Role: Admin

Regular Users
Email: islam.alissa2002@gmail.com / jane@example.com

Password: password

Role: User

For Admin apis
use Postman_Collection.json file