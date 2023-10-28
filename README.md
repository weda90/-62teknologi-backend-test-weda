<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="200" alt="Laravel Logo"></a></p>

# <p align="center">62teknologi backend test</p>

---

## Step 1: Clone the Repository

Clone the repository from GitHub to your local machine.

```
git clone https://github.com/weda90/-62teknologi-backend-test-weda.git 62teknologi-backend-test-weda
```

## Step 2: Navigate to the Project Directory

Navigate to the project directory using the following command:

```
cd 62teknologi-backend-test-weda
```

## Step 3: Install Dependencies

Install the project dependencies using Composer.

```
composer install
```

## Step 4: Create Environment File

Copy the `.env_example` file and rename it to `.env`.

```
cp .env_example .env
```

## Step 5: Generate Application Key

Generate the application key using the following command:

```
php artisan key:generate
```

## Step 6: Configure Database Connection

Open the `.env` file and configure the database connection settings according to your environment. example:

```
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

## Step 7: Run the Application

Start the Laravel development server using the following command:

```
php artisan serve
```

The application should now be running on [http://localhost:8000](http://localhost:8000).

That's it! You have successfully set up and run the Laravel application.

---

## Tools Used

This project was developed using the following tools:

- [Visual Studio Code](https://code.visualstudio.com/): A powerful source code editor with built-in Git integration.

- [OpenAI](https://openai.com/): A cutting-edge artificial intelligence platform that provides the language model used in this project.

- [Laravel](https://laravel.com/): A popular PHP framework for building web applications.

- [PostgreSQL](https://www.postgresql.org/): An open-source relational database management system.

- [Docker](https://www.docker.com/): A platform that allows you to automate the deployment of applications using containerization.

Feel free to explore these tools to learn more about them and how they contribute to the development of this project.