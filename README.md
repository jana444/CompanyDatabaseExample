# CompanyDatabaseExample

* Bingo Health Care Management System * 

Bingo is a web-based health care management system that allows health care agencies to manage clients, nurses, and contracts for at-home care services. 
The system provides a way to register clients, assign nurses to clients, create contracts, and manage visit reports for the provided health care services.

## Table of Contents
- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Database Structure](#database-structure)
- [Technologies Used](#technologies-used)
- [License](#license)
- [Contact](#contact)

## Features
- **Client Management:** Add, view, and delete clients. The system prevents the deletion of clients with active contracts.
- **Contract Management:** Create, view, and delete contracts between clients and nurses. Nurses are automatically assigned based on availability.
- **Visit Report Management:** Record and display detailed visit reports for each contract. View the history of visit reports for individual clients.
- **Nurse Substitution:** Manage nurse substitutions for clients when regular nurses are unavailable.
- **Validation:** All forms are validated for correct input.

## Installation

### Prerequisites
- PHP 7.4+ (Recommended: PHP 8.x)
- MySQL or MariaDB (Database server)
- A web server like Apache or Nginx

### Steps

1. **Clone the repository:**

    ```bash
    git clone https://github.com/jana444/CompanyDatabaseExample.git
    cd CompanyDatabaseExample
    ```

2. **Database Setup:**
   - Import the provided SQL file into your database:
  
      ```bash
     mysql -u username -p database_name < path/to/cpsc2221_project.sql
     ```
     - Replace username with your MySQL username if you're using a different one.
     - Replace database_name with your desired database name.
     - path/to/cpsc2221_project.sql should be replaced with the path to where the SQL file is located.
   
   - Update the `database/config.php` file with your database connection details:
   
     ```php
     define('DBHOST', 'localhost');
     define('DBNAME', 'your_database_name');
     define('DBUSER', 'your_username');
     define('DBPASS', 'your_password');
     ```

3. **Run the project locally:**
   - If you’re using PHP's built-in server, navigate to the root folder and run:

     ```bash
     php -S localhost:8000
     ```

4. **Access the application:**
   Open your browser and navigate to `http://localhost:8000` or the equivalent URL depending on your web server setup.

## Usage

### Client Management
- Navigate to the **Clients** tab to add new clients.
- Use the form to input details like name, address, phone number, and client type (e.g., Senior, Disabled, Other).
- Clients without scheduled visits can be seen under the "Clients w/o Scheduled Visit" section.

### Contract Management
- Contracts are created for clients based on availability.
- Assign nurses automatically by the system to clients when creating new contracts.

### Visit Reports
- Detailed visit reports can be viewed under the "Visit Reports" section, showing the services provided during each home visit.

### Nurse Substitution
- Manage nurse substitution periods when the regular nurse is unavailable.

## Database Structure

The project uses the following key tables:

- `client`: Stores client details.
- `contract`: Stores contract details, linking clients with scheduled services.
- `visitreport`: Stores visit reports for each contract.
- `nurse`: Stores nurse information.
- `substitution`: Manages nurse substitution periods.
- `detailedvisitreports` (view): Provides a detailed report of visits.

## Technologies Used
- **Backend:** PHP 8.x, PDO for database interactions.
- **Frontend:** HTML5, CSS3, JavaScript (GSAP for animations).
- **Database:** MySQL/MariaDB.
- **WebServer:** Apache or Nginx

## License

This project is licensed under the Creative Commons Attribution-NoDerivatives 4.0 International (CC BY-ND 4.0).

You are free to:

Share — copy and redistribute the material in any medium or format.
Under the following terms:

Attribution — You must give appropriate credit, provide a link to the license, and indicate if changes were made.
No derivatives — If you remix, transform, or build upon the material, you may not distribute the modified material.

## Contact

For any questions or issues, feel free to reach out:
- **Project Owner:** Jana Krizanova
- **Email:** info@janawebs.com
