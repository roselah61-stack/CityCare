# CityCare Medical Centre - Hospital Management System

CityCare is a comprehensive, scalable, and modern Hospital Management System built with Laravel. It supports full real-world hospital workflows from patient registration to billing and pharmacy management.

## Key Features

- **Role-Based Authorization**: Distinct dashboards and permissions for Administrator, Doctor, Pharmacist, Receptionist, Cashier, and Patient.
- **Patient Management**: Centralized registration, profile tracking, and clinical history.
- **Appointment Scheduling**: Real-time doctor availability checks to prevent double-booking with AJAX-based slot loading.
- **Consultation Module**: Doctors can record diagnoses, clinical notes, and issue digital prescriptions.
- **Pharmacy Management**: 
  - Dispense medications based on prescriptions.
  - Inventory tracking with stock logs.
  - Low-stock alerts and expiry date management.
- **Billing & Payments**: 
  - Generate invoices for consultations and medications.
  - Support for multiple payment methods (Cash, Mobile Money, Card).
  - Payment status tracking.
- **Reporting & Analytics**: 
  - Daily revenue trends.
  - Appointment summaries.
  - Exportable reports (CSV).
- **Modern UI**: Responsive design with a beautiful blue gradient theme inspired by modern healthcare platforms.

## Installation & Setup

1. **Clone the repository**:
   ```bash
   git clone <repository-url>
   cd CityCare
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install && npm run dev
   ```

3. **Environment Setup**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Configure your database settings in the `.env` file.*

4. **Database Migrations & Seeding**:
   ```bash
   php artisan migrate:fresh --seed
   ```

## Default User Accounts

Use the following credentials to test the different roles (password is `password` for all):

- **Admin**: `admin@citycare.com`
- **Doctor**: `smith@citycare.com` or `doe@citycare.com`
- **Pharmacist**: `pharmacist@citycare.com`
- **Receptionist**: `receptionist@citycare.com`
- **Cashier**: `cashier@citycare.com`
- **Patient**: `patient@citycare.com`

## Technologies Used

- **Backend**: Laravel 11.x
- **Frontend**: Bootstrap 5, Blade, Chart.js
- **Database**: MySQL
- **Interactions**: AJAX (Fetch API)

## Next Steps & Recommendations

- **Email Notifications**: Implement automated email reminders for upcoming appointments and low-stock alerts.
- **Telemedicine**: Integrate a video conferencing tool (like Jitsi or Zoom) for remote consultations.
- **Patient Portal**: Expand the patient dashboard to allow viewing of lab results and medical history.
- **Lab Management**: Add a module for laboratory tests, results entry, and integration with consultations.
- **Insurance Integration**: Support for insurance provider billing and claim tracking.
