# Expense Tracker - Laravel Project

This is an expense tracker application based on PHP framework Laravel.

## Getting Started

Follow these steps to set up the project on your local machine.

### Step 1: Clone the Repository

In **XAMPP**: </br>
Go to your **'htdocs'** folder and open **CMD** there and clone the repository. </br>

In **Laragon**: </br>
Go to your **'www '** folder and open **CMD** there and clone the repository. </br>


```
git clone https://github.com/Abdul-Moez/Expense-Tracker.git
```

```
cd Expense-Tracker/expt_lvl
```


### Step 2: Install Composer Dependencies

Use Composer to install the required PHP dependencies for the project. This will create the vendor folder.
</br>

```
composer install
```

### Step 3: Create a .env File

Copy the .env.example file to create a new .env file, which you can customize with your environment settings.

```
cp .env.example .env
```

### Step 4: Generate an Application Key

Laravel requires an application key for security purposes. Generate one with this command:

```
php artisan key:generate
```

## Step 5: Configure Database Connection

Open the .env file and configure your database connection settings. Modify the following variables according to your database setup:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### Step 6: Run Migrations and Seed the Database

Run the following commands to create the database schema:

```
php artisan migrate
```

### Step 7: Start the Development Server

Launch the Laravel development server to run the application locally:

```
php artisan serve
```

The application will be accessible at `http://localhost:8000` in your web browser.

### To Do

<ul>
  <li>Allow user to add sources separately</li>
  <li>Allow user to export data in .pdf and .xlsx format</li>
  <li>Allow user to edit their profile</li>
  <li><s>Allow user to reset their password</s></li>
</ul>

### License
This project is open-source and available under the MIT License.
