Ecommerce API
A robust Laravel-based RESTful API for an eCommerce platform, supporting CRUD operations for Categories, SubCategories, and Products with Variants. Built with PHP, MySQL, and enhanced with caching, validation, and Docker support.

Overview
Framework: Laravel 8.x+
Database: MySQL
Features: CRUD for categories, subcategories, products, variants, image uploads, caching.
Environment: Local (XAMPP) or Dockerized deployment.
Table of Contents
Features
Full CRUD functionality for Categories, SubCategories, and Products.
Support for product variants (e.g., size, color, stock).
Image upload and management using Laravel Storage.
Caching with Laravel Cache for improved performance.
Request validation with Laravel Validator.
Eager loading of relationships (e.g., categories with subcategories).
Dockerized environment for consistent development.
Prerequisites
PHP: >= 7.4
Composer: For dependency management
MySQL: For database storage
XAMPP: For local server (if not using Docker)
Git: For version control
Docker (optional): For containerized setup
Postman or cURL (optional): For API testing
Installation

1. Clone the Repository
   bash

Collapse

Wrap

Copy
git clone https://github.com/sajidans/Ecommarce-api.git
cd ecommerce-api 2. Install Dependencies
bash

Collapse

Wrap

Copy
composer install 3. Configure Environment
Copy the example environment file:
bash

Collapse

Wrap

Copy
cp .env.example .env
Update .env with your MySQL credentials (ensure XAMPP MySQL is running):
text

Collapse

Wrap

Copy
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce_db
DB_USERNAME=root
DB_PASSWORD=
Generate an application key:
bash

Collapse

Wrap

Copy
php artisan key:generate 4. Database Setup
Run migrations to create tables:
bash

Collapse

Wrap

Copy
php artisan migrate
Seed the database with sample data:
bash

Collapse

Wrap

Copy
php artisan storage:link 6. Start the Server
Run the Laravel development server:
bash

Collapse

Wrap

Copy
php artisan serve
Access the API at http://localhost:8000.
Docker Setup
For a containerized environment:

1. Prerequisites
   Docker and Docker Compose installed.
2. Build and Run
   bash

Collapse

Wrap

Copy
docker-compose up --build
Access the API at http://localhost:80. 3. Stop Containers
bash

Collapse

Wrap

Copy
docker-compose down
API Endpoints
Categories
GET /api/categories: List all categories with subcategories.
POST /api/categories: Create a category (e.g., {"name": "Electronics"}).
GET /api/categories/{id}: Show a category.
PUT /api/categories/{id}: Update a category.
DELETE /api/categories/{id}: Delete a category.
SubCategories
GET /api/subcategories: List all subcategories with categories.
POST /api/subcategories: Create a subcategory (e.g., {"category_id": 1, "name": "Mobiles"}).
GET /api/subcategories/{id}: Show a subcategory.
PUT /api/subcategories/{id}: Update a subcategory.
DELETE /api/subcategories/{id}: Delete a subcategory.
Products
GET /api/products: List all products with variants, categories, and subcategories.
POST /api/products: Create a product (e.g., {"name": "Smartphone", "category_id": 1, "subcategory_id": 1, "price": 499.99, "variants": "[{\"name\": \"128GB\", \"price\": 499.99, \"stock\": 10}]"}).
GET /api/products/{id}: Show a product.
PUT /api/products/{id}: Update a product.
DELETE /api/products/{id}: Delete a product.
Usage
Test endpoints using Postman or cURL.
Example cURL to create a product:
bash

Collapse

Wrap

Copy
curl -X POST "http://localhost:8000/api/products" \
-H "Content-Type: application/json" \
-d '{"name":"Smartphone","category_id":1,"subcategory_id":1,"price":499.99,"variants":"[{\"name\":\"128GB\",\"price\":499.99,\"stock\":10}]"}'
Testing
Run unit tests (if implemented): php artisan test.
Manually test API endpoints with Postman or a similar tool.
Contributing
Fork the repository.
Create a feature branch: git checkout -b feature/new-feature.
Commit changes: git commit -m "Add new feature".
Push to the branch: git push origin feature/new-feature.
Open a Pull Request.
License
This project is licensed under the MIT License. See the LICENSE file for details.

text

Collapse

Wrap

Copy

### How to Add to Your Laravel Project

1. **Create the File**:

    - Open a text editor (e.g., Notepad, VS Code).
    - Copy the content above and paste it.

2. **Save the File**:

    - Save it as `README.md` in your project root directory: `C:/xampp/htdocs/ecommerce-api/`.
    - Ensure the file extension is `.md` (Markdown format).
    - Use UTF-8 encoding for compatibility.

3. **Add to Git**:
    - Open a terminal in `C:/xampp/htdocs/ecommerce-api/`.
    - Run the following commands:
        ```bash
        git add README.md
        git commit -m "Add professional README file"
        git push origin master
        If the remote is not set, add it first:
        bash
        ```
4. **API Documentation**: -
   Open a prject folder and search API-Documentation.text.
   Collapse

Wrap

Copy
git remote add origin https://github.com/sajidans/Ecommarce-api.git
Verify:
Visit your GitHub repository (e.g., https://github.com/sajidans/Ecommarce-api.git) and confirm that README.md is displayed and rendered correctly on the main page.
