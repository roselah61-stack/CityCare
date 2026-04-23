# CityCare Medical Centre - Hospital Management System

CityCare is a comprehensive, scalable, and modern Hospital Management System built with Laravel 11. It supports full real-world hospital workflows from patient registration to billing and pharmacy management, designed for healthcare facilities in Uganda and beyond.

## 🌟 Key Features

### **Role-Based Authorization System**
- **Administrator**: Full system access, user management, system configuration
- **Doctor**: Patient consultations, prescriptions, medical records
- **Pharmacist**: Inventory management, prescription dispensing, stock tracking
- **Receptionist**: Patient registration, appointment scheduling, front desk operations
- **Cashier**: Billing, payment processing, financial reporting
- **Patient**: Personal dashboard, appointment booking, medical history access

### **Core Hospital Workflows**
- **Patient Management**: Centralized registration, profile tracking, clinical history
- **Appointment Scheduling**: Real-time doctor availability checks with AJAX-based slot loading
- **Consultation Module**: Digital recording of diagnoses, clinical notes, and prescriptions
- **Pharmacy Management**: Inventory tracking, dispensing, low-stock alerts, expiry management
- **Billing & Payments**: Multi-method payment support (Cash, Mobile Money, Card)
- **Reporting & Analytics**: Revenue trends, appointment summaries, exportable reports

### **Advanced Features**
- **Real-time Availability**: Prevent double-booking with live doctor scheduling
- **Digital Prescriptions**: Electronic prescription generation and tracking
- **Inventory Automation**: Automatic stock alerts and expiry date monitoring
- **Export Capabilities**: CSV reports for revenue, appointments, and analytics
- **Responsive Design**: Mobile-friendly interface with modern healthcare aesthetics

## 🏥 System Modules Overview

### **1. Authentication & Authorization**
- **Login System**: Secure role-based authentication
- **Dashboard Access**: Personalized dashboards for each role
- **Permission Management**: Granular access control system
- **Session Management**: Secure session handling with timeout

### **2. Patient Management Module**
- **Registration**: Complete patient registration with demographics
- **Medical History**: Comprehensive medical record tracking
- **Profile Management**: Patient profile updates and maintenance
- **Allergy Tracking**: Medical allergy documentation and alerts

### **3. Appointment Scheduling Module**
- **Doctor Availability**: Real-time availability calendar
- **Booking System**: Patient appointment booking interface
- **Conflict Prevention**: Automatic double-booking prevention
- **Status Tracking**: Appointment status management (pending, confirmed, completed, cancelled)

### **4. Consultation Module**
- **Clinical Notes**: Digital consultation record keeping
- **Diagnosis Management**: Standardized diagnosis recording
- **Vitals Tracking**: Patient vital signs documentation
- **Prescription Generation**: Electronic prescription creation

### **5. Pharmacy Management Module**
- **Inventory Control**: Real-time stock tracking
- **Dispensing System**: Prescription-based medication dispensing
- **Stock Alerts**: Low-stock and expiry date notifications
- **Supplier Management**: Medicine supplier and procurement tracking

### **6. Billing & Payments Module**
- **Invoice Generation**: Automated billing for consultations and medications
- **Payment Processing**: Multi-method payment acceptance
- **Financial Reporting**: Revenue and payment analytics
- **Receipt Management**: Digital receipt generation and tracking

### **7. Reporting & Analytics Module**
- **Revenue Reports**: Daily, weekly, monthly revenue analytics
- **Appointment Statistics**: Patient visit and appointment metrics
- **Inventory Reports**: Stock levels and movement tracking
- **Export Functionality**: CSV export for all major reports

## 🚀 Installation & Setup

### **Prerequisites**
- PHP 8.2+ 
- Composer 2.0+
- Node.js 16+
- MySQL 8.0+ or PostgreSQL 12+
- Web server (Apache/Nginx)

### **Step-by-Step Installation**

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/roselah61-stack/CityCare.git
   cd CityCare
   ```

2. **Install Dependencies**:
   ```bash
   composer install --optimize-autoloader --no-dev
   npm install && npm run build
   ```

3. **Environment Configuration**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   
   **Configure Database Settings**:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=citycare
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

4. **Database Setup**:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Storage Configuration**:
   ```bash
   php artisan storage:link
   ```

6. **Optimize Application**:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

7. **Start Development Server**:
   ```bash
   php artisan serve
   ```

## 👥 Default User Accounts

### **Sample Data Credentials** (Password: `password123`)

**Medical Staff**:
- **Dr. Sarah Nankya**: `sarah.nankya@citycare.ug` (General Medicine)
- **Dr. Michael Mwanga**: `michael.mwanga@citycare.ug` (Cardiology)
- **Dr. Rebecca Nakato**: `rebecca.nakato@citycare.ug` (Pediatrics)

**Support Staff**:
- **Joseph Lubega**: `joseph.lubega@citycare.ug` (Pharmacist)
- **Grace Namukasa**: `grace.namukasa@citycare.ug` (Receptionist)

**Patients**:
- **John Mugisha**: `john.mugisha@gmail.com`
- **Esther Nalwoga**: `esther.nalwoga@gmail.com`

### **System Accounts** (Password: `password`)
- **Administrator**: `admin@citycare.com`
- **Doctor**: `doctor@citycare.com`
- **Pharmacist**: `pharmacist@citycare.com`
- **Receptionist**: `receptionist@citycare.com`
- **Patient**: `patient@citycare.com`

## 🛠️ Technologies Used

### **Backend Technologies**
- **Framework**: Laravel 11.x
- **Authentication**: Laravel Sanctum
- **Database**: MySQL/PostgreSQL
- **Queue System**: Redis
- **File Storage**: Local/Cloud Storage

### **Frontend Technologies**
- **CSS Framework**: Bootstrap 5.3
- **JavaScript**: Vanilla JS with Fetch API
- **Charts**: Chart.js
- **Icons**: Bootstrap Icons
- **Templating**: Blade Templates

### **Development Tools**
- **Package Manager**: Composer
- **Asset Pipeline**: Vite
- **Version Control**: Git
- **Testing**: PHPUnit

## 📱 User Interface Screenshots

### **Dashboard Views**
- **Administrator Dashboard**: System overview with KPI metrics
- **Doctor Dashboard**: Patient appointments and consultation queue
- **Patient Dashboard**: Personal appointments and medical history
- **Pharmacy Dashboard**: Inventory levels and prescription queue

### **Key Interfaces**
- **Appointment Scheduling**: Calendar-based booking interface
- **Patient Registration**: Comprehensive patient data entry
- **Consultation Room**: Digital clinical note taking
- **Pharmacy Dispensing**: Prescription fulfillment interface
- **Billing System**: Invoice generation and payment processing

### **Mobile Responsiveness**
- **Responsive Design**: Fully mobile-optimized interface
- **Touch-Friendly**: Mobile-optimized interactions
- **Progressive Web App**: PWA capabilities for mobile access

## 🔧 Configuration & Customization

### **Environment Variables**
```env
APP_NAME=CityCare Medical Centre
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
```

### **Customization Options**
- **Theme Colors**: Customize primary and secondary colors
- **Hospital Information**: Update hospital details and branding
- **Payment Methods**: Configure supported payment options
- **Email Templates**: Customize notification templates

## 🚀 Deployment

### **Local Development**
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

### **Production Deployment**
```bash
# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Set proper permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### **Docker Deployment**
```bash
docker build -t citycare .
docker run -p 8000:8000 citycare
```

## 🔄 Maintenance & Support

### **Regular Tasks**
- **Database Backups**: Daily automated backups
- **Log Monitoring**: Regular error log review
- **Performance Optimization**: Monthly performance tuning
- **Security Updates**: Regular dependency updates

### **Troubleshooting**
- **Clear Caches**: `php artisan optimize:clear`
- **Reset Database**: `php artisan migrate:fresh --seed`
- **Check Logs**: `tail -f storage/logs/laravel.log`

## 📈 Future Enhancements

### **Planned Features**
- **Telemedicine Integration**: Video consultation capabilities
- **Laboratory Management**: Lab test tracking and results
- **Insurance Integration**: Insurance billing and claims
- **Mobile App**: Native mobile applications
- **AI Integration**: Symptom checking and diagnosis assistance

### **Technical Improvements**
- **API Development**: RESTful API for third-party integrations
- **Real-time Notifications**: WebSocket-based notifications
- **Advanced Analytics**: Machine learning for predictive analytics
- **Multi-tenant Support**: Support for multiple hospital locations

## 📞 Support & Documentation

### **Documentation**
- **API Documentation**: Comprehensive API reference
- **User Manuals**: Role-specific user guides
- **Technical Documentation**: System architecture and development guide

### **Community Support**
- **GitHub Issues**: Report bugs and request features
- **Documentation Wiki**: Community-maintained documentation
- **Discussion Forum**: User community support

---

**CityCare Medical Centre** - Modern Healthcare Management Solution  
*Built with ❤️ for Healthcare Excellence*
