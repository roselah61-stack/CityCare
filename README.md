CityCare Medical Centre
README (Setup Guide)
Github project link: https://github.com/roselah61-stack/CityCare
Live system access: https://citycare-main-uwhs9y.free.laravel.cloud/
Introduction
CityCare Medical Centre is a hospital management system developed using Laravel. It helps healthcare facilities manage patients, appointments, billing, and pharmacy services efficiently.
Setup Steps
1. Clone the Project
Download the project from GitHub and open it in your working directory.
•	git clone https://github.com/roselah61-stack/CityCare.git
•	cd CityCare
2. Install Dependencies
Install required backend and frontend packages.
•	composer install
•	npm install
•	npm run dev
3. Configure Environment File
Create and configure the environment file.
•	cp .env.example .env
Update database name, username, and password in the .env file.
4. Generate Application Key
Run the command below to generate the application key.
•	php artisan key:generate
5. Set Up Database
Create a database (e.g., citycare) and run migrations.
•	php artisan migrate --seed
6. Start the Server
Run the development server and open the system in your browser.
•	php artisan serve
•	http://127.0.0.1:8000
Default Login Credentials
No	Role	Email	Password
1	Admin	nrosemary4444@gmail.com	roselah@2026
2	Doctor	sarah.nankya@citycare.ug	password123
3	Pharmacist	joseph.lubega@citycare.ug	password123
4	Receptionist	grace.namukasa@citycare.ug	password123
5	Cashier	davis@citycare.com	password123
6	Patient	john.mugisha@gmail.com	password123


Conclusion
After completing the above steps, the system will be ready for use. You can log in using the provided accounts and explore different features.
