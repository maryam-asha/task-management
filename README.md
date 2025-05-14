Task Management API
A robust task management API built with Laravel 12, featuring role-based access control (Admin/User), task ownership, status workflows, and comment functionality.
Description
The Task Management API is a RESTful API designed for managing tasks with a focus on security, scalability, and maintainability. It supports CRUD operations (Create, Read, Update, Delete) for tasks, task statuses, and comments, with advanced features like task filtering and role-based authorization. The API is built using a service layer architecture and provides consistent JSON responses.
Key Features

User Authentication: Secure API authentication using Laravel Sanctum.
Role-Based Access Control: Admins can manage task statuses, while users can manage their own tasks and comments.
CRUD Operations: Full support for creating, reading, updating, and deleting tasks, statuses, and comments.
Task Filtering: Search tasks by title, priority (low, medium, high), and status (e.g., pending, in progress, completed).
Task Comments: Users can add comments to tasks for collaboration.
Form Requests: Input validation using custom Laravel Form Request classes.
Custom Response Format: Unified JSON responses with success, message, data, and errors fields.
API Resources: Consistent data transformation using Laravel API Resources.
Service Layer: Business logic encapsulated in services for better maintainability.
Authorization: Role-based policies for secure access control.
Seeders: Pre-populated database with initial data for testing.
Pagination: Planned support for paginated responses (to be implemented).

Technologies Used

Laravel 12: PHP framework for building the API.
PHP: Backend programming language.
MySQL: Database for storing users, roles, tasks, statuses, and comments.
XAMPP: Local development environment for MySQL and Apache.
Composer: PHP dependency manager.
Laravel Sanctum: API authentication package.
Postman: Tool for testing API endpoints.

Installation
Prerequisites
Ensure the following are installed:

XAMPP: For running MySQL and Apache servers locally.
Composer: For managing PHP dependencies.
PHP: Version compatible with Laravel 12 (e.g., PHP 8.2+).
MySQL: Database for the project.
Postman: For testing API requests.

Steps to Run the Project

Clone the Repository  
git clone https://github.com/maryam-asha/task-management


Navigate to the Project Directory  
cd task-management


Install Dependencies  
composer install


Create Environment FileCopy the example environment file and configure your database settings:  
cp .env.example .env

Update .env with your MySQL credentials, database name (e.g., task_manager_db), and other settings:  
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager_db
DB_USERNAME=root
DB_PASSWORD=


Generate Application Key  
php artisan key:generate


Run MigrationsCreate the database tables:  
php artisan migrate


Seed the DatabasePopulate the database with initial data:  
php artisan db:seed


Run the ApplicationStart the Laravel development server:  
php artisan serve


Test the APIUse the provided Postman collection to interact with the API endpoints. Import the collection from:Postman Collection


Admin Login for Testing
To test admin-specific features (e.g., managing task statuses), use the seeded admin credentials:  
Email: admin@example.com
Password: password

Seeded Data
The database seeder populates the following data:

Roles: 2 roles (admin, user).
Users: 
1 Admin user (admin@example.com).
1 Regular user (user@example.com).


Statuses: 3 statuses (Pending, In Progress, Completed).
Tasks: 1 sample task assigned to the regular user.
Comments: No comments by default (can be added via API).

API Endpoints
Below is a summary of the main API endpoints. Refer to the Postman collection for detailed request/response examples.

Authentication:

POST /api/register: Register a new user (requires name, email, password, optional role).
POST /api/login: Authenticate and receive an API token.
POST /api/logout: Revoke the current token (requires authentication).


Tasks (requires authentication):

GET /api/tasks: List tasks with optional filtering (search, priority, status_id).
POST /api/tasks: Create a new task.
GET /api/tasks/{id}: View a specific task.
PUT /api/tasks/{id}: Update a task (user must own the task or be admin).
DELETE /api/tasks/{id}: Delete a task (user must own the task or be admin).


Statuses (admin-only for create/update/delete):

GET /api/statuses: List all statuses.
POST /api/statuses: Create a new status (admin only).
PUT /api/statuses/{id}: Update a status (admin only).
DELETE /api/statuses/{id}: Delete a status (admin only).


Comments (requires authentication):

POST /api/comments: Add a comment to a task.



Response Format
All API responses follow a consistent JSON structure:  
{
  "success": true,
  "message": "Operation completed successfully",
  "data": {}, // Resource data (e.g., task, user)
  "errors": null // Validation or error details
}

Example success response:  
{
  "success": true,
  "message": "Task created successfully",
  "data": {
    "id": 1,
    "title": "Sample Task",
    "description": "This is a sample task",
    "priority": "medium",
    "user": { "id": 2, "name": "User", "email": "user@example.com" },
    "status": { "id": 1, "name": "Pending" },
    "comments": [],
    "created_at": "2025-05-14T19:45:00Z"
  },
  "errors": null
}

Example error response:  
{
  "success": false,
  "message": "Validation failed",
  "data": null,
  "errors": {
    "email": ["The email has already been taken."]
  }
}

Project Structure
Key directories and files:  
app/
├── Helpers/ResponseHelper.php        # Custom response formatter
├── Http/
│   ├── Controllers/Api/             # API controllers (Auth, Task, Status, Comment)
│   ├── Requests/                    # Form request classes for validation
│   ├── Resources/                   # API resource classes (User, Task, Status, Comment)
├── Models/                          # Eloquent models (User, Role, Task, Status, Comment)
├── Policies/                        # Authorization policies
├── Services/                        # Business logic services
database/
├── migrations/                      # Database schema
├── seeders/                         # Database seeders
routes/api.php                       # API routes

Testing

Unit Tests: Test service layer logic (e.g., AuthServiceTest, TaskServiceTest) using PHPUnit.Run tests:  php artisan test


API Testing: Use the Postman collection to test all endpoints manually.
Seeded Data: Use the seeded admin and user accounts to test role-based access.

Future Improvements

Pagination: Implement pagination for task listing.
Notifications: Add email or real-time notifications for task updates.
API Documentation: Generate detailed documentation using Laravel OpenAPI or Swagger.
Caching: Cache frequently accessed data (e.g., statuses) for performance.
Advanced Filtering: Add more task filtering options (e.g., by date or user).

Contributing
This project is for training and learning purposes. Contributions are welcome! Please:  

Fork the repository.
Create a feature branch (git checkout -b feature/new-feature).
Commit changes (git commit -m 'Add new feature').
Push to the branch (git push origin feature/new-feature).
Open a pull request.
