Automobile Management System
This is a web application built with PHP and MySQL for managing automobile records. It allows users to add, edit, and delete automobile entries in a database.

Features
User Authentication: Users can log in using their email and password.
CRUD Operations: Users can perform CRUD (Create, Read, Update, Delete) operations on automobile records.
Data Validation: All user input is properly validated on the server side to ensure data integrity and security.
POST-Redirect-GET Pattern: The application follows the POST-Redirect-GET pattern to handle form submissions, ensuring a clean user experience and preventing duplicate form submissions.
Database Protection: Certain pages are protected to prevent unauthorized access and modifications to the database.
Installation
Clone the Repository:

bash
Copier le code
git clone https://github.com/your_username/automobile-management.git
Database Setup:

Create a MySQL database named automobile_management.
Import the database.sql file provided in the repository to set up the required tables.
Configuration:

Rename config-sample.php to config.php.
Update config.php with your MySQL database credentials.
Start the Server:

You can use a local server environment like XAMPP, WAMP, or MAMP to run the application.
Access the Application:

Navigate to http://localhost/automobile-management in your web browser.
Usage
Login:

Use the provided login credentials (umsi@umich.edu / php123) to log in.
View Automobiles:

Once logged in, you'll see a list of automobiles in the database.
Add New Entry:

Click on the "Add New Entry" button to add a new automobile record.
Edit Record:

Click on the "Edit" link next to a record to edit its details.
Delete Record:

Click on the "Delete" link next to a record to delete it.
Contributors
Asmaa CHOUAI
License
This project is licensed under the MIT License.
