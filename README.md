# Product Management 

A simple web module to manage products and categories, featuring authentication, authorization, and role-based access control. The system includes a user-friendly interface for CRUD operations on products and categories, along with basic search and filtering functionality.

## Features

- [x] **User Authentication and Authorization**
- [x] **Product Management** (Create, Read, Update, Delete)
- [x] **Role-Based Access Control** (Admin, Operation, and Customer users)
- [x] **Export Products** to various formats

## Installation

Follow these steps to set up the project:

1. Clone the repository:
    ```bash
    git clone https://github.com/hamada-emam/algoriza-taskproduct-managment-module.git
    ```

2. Navigate into the project directory:
    ```bash
    cd algoriza-taskproduct-managment-module
    ```

3. Install project dependencies and autoload classes:
    ```bash
    composer install && composer dump-autoload
    ```

4. Run database migrations and seed the database:
    ```bash
    php artisan migrate --seed
    ```

5. Generate the application key:
    ```bash
    php artisan key:generate
    ```

6. Serve the application:
    ```bash
    php artisan serve --host 0.0.0.0
    ```

7. Open the application in your browser:
    - `http://localhost:8000`
    - OR, if using a different local IP: `http://your-local-ip:8000`

## Default Users

Use the following default credentials to log into the system:

- **Admin User:**
    - Email: `adminuser@example.com`
    - Password: `123456`

- **Operation User:**
    - Email: `operationuser@example.com`
    - Password: `123456`

- **Customer User:**
    - Email: `customeruser@example.com`
    - Password: `123456`

## Developer Assignment

This project includes the following tasks for implementation:

1. **Create a simple web module** with related database tables to perform CRUD operations:
   1.1) **Products Table** (with the following fields):
   - Product Name
   - Description
   - Category (dropdown selection)
   - Tags (comma-separated words)
   - Picture (file upload)
   
   1.2) **Category Table**:
   - Category Name
   - Parent Category Name (optional)
   - Is Active (boolean)
   
2. **Search and Filtering**: Add basic search and filtering functionality to both the categories and products lists.

3. **Styling**: Use basic CSS (like Bootstrap or any other) to style the pages.

4. **README.md**: Ensure this `README.md` file is included with steps to set up and run the application.

5. **Push the Code**: Push your code (along with SQL dump or migrations) to GitHub or another git provider, and share the repository link.

### Notes

- You can develop the pages using PHP natively or with your preferred MVC framework.
- Adding simple authorization logic to protect the module is a plus.
- Creating the database using SQL migrations is a plus.

