# momentum-solutions-task

### Prerequisites

* PHP >= 8.1
* Composer
* MySQL or any other supported database
* Node.js and npm/yarn (if applicable)

### Installation

#### Follow these steps to set up the project locally.

##### 1. Clone the repository

   git clone https://github.com/fadyreda99/momentum-solutions-task.git
   
    cd momentum-solutions-task

##### 2. Install dependencies

   **_composer install_**

3. ##### Set up environment variables

   cp .env.example .env

   Generate the application key:

    **_php artisan key:generate_**
4. ##### Set up the database

   DB_DATABASE=yourdatabase
   DB_USERNAME=yourusername
   DB_PASSWORD=yourpassword

   **_php artisan migrate --seed_**
5. ##### JWT Authentication

   **_php artisan jwt:secret_**
6. ##### Run the application

   **_php artisan serve_**


