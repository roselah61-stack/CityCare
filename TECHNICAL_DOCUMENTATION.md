# CityCare Medical Centre - Technical Documentation

## 📋 Table of Contents
1. [System Architecture](#system-architecture)
2. [Database Schema](#database-schema)
3. [API Documentation](#api-documentation)
4. [Security Implementation](#security-implementation)
5. [Performance Optimization](#performance-optimization)
6. [Development Guidelines](#development-guidelines)
7. [Testing Strategy](#testing-strategy)
8. [Deployment Architecture](#deployment-architecture)

---

## 🏗️ System Architecture

### **Application Architecture**
```
┌─────────────────────────────────────────────────────────────┐
│                    Presentation Layer                        │
├─────────────────────────────────────────────────────────────┤
│  Laravel Blade Templates  │  Bootstrap 5  │  JavaScript    │
└─────────────────────────────────────────────────────────────┘
                                │
┌─────────────────────────────────────────────────────────────┐
│                    Application Layer                         │
├─────────────────────────────────────────────────────────────┤
│  Controllers  │  Middleware  │  Services  │  Validators    │
└─────────────────────────────────────────────────────────────┘
                                │
┌─────────────────────────────────────────────────────────────┐
│                     Business Layer                           │
├─────────────────────────────────────────────────────────────┤
│     Models     │    Relationships    │    Business Logic   │
└─────────────────────────────────────────────────────────────┘
                                │
┌─────────────────────────────────────────────────────────────┐
│                    Data Layer                                │
├─────────────────────────────────────────────────────────────┤
│   MySQL/PostgreSQL   │   Redis Cache   │   File Storage    │
└─────────────────────────────────────────────────────────────┘
```

### **Design Patterns Used**
- **MVC Pattern**: Model-View-Controller architecture
- **Repository Pattern**: For data access abstraction
- **Factory Pattern**: For object creation
- **Observer Pattern**: For event handling
- **Strategy Pattern**: For payment processing

---

## 🗄️ Database Schema

### **Core Tables**

#### **Users Table**
```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    date_of_birth DATE,
    role_id BIGINT,
    profile_image VARCHAR(255),
    remember_token VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);
```

#### **Patients Table**
```sql
CREATE TABLE patients (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone VARCHAR(20),
    gender ENUM('male', 'female', 'other'),
    address TEXT,
    date_of_birth DATE,
    emergency_contact VARCHAR(255),
    medical_history TEXT,
    allergies TEXT,
    status ENUM('Active', 'Inactive') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### **Appointments Table**
```sql
CREATE TABLE appointments (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    patient_id BIGINT NOT NULL,
    doctor_id BIGINT NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    reason TEXT,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES users(id),
    FOREIGN KEY (doctor_id) REFERENCES users(id)
);
```

#### **Consultations Table**
```sql
CREATE TABLE consultations (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    appointment_id BIGINT,
    patient_id BIGINT NOT NULL,
    doctor_id BIGINT NOT NULL,
    chief_complaint TEXT,
    diagnosis TEXT,
    notes TEXT,
    blood_pressure VARCHAR(20),
    temperature DECIMAL(4,1),
    weight DECIMAL(5,2),
    heart_rate INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (appointment_id) REFERENCES appointments(id),
    FOREIGN KEY (patient_id) REFERENCES users(id),
    FOREIGN KEY (doctor_id) REFERENCES users(id)
);
```

#### **Prescriptions Table**
```sql
CREATE TABLE prescriptions (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    consultation_id BIGINT,
    patient_id BIGINT NOT NULL,
    doctor_id BIGINT NOT NULL,
    notes TEXT,
    status ENUM('active', 'completed', 'cancelled') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (consultation_id) REFERENCES consultations(id),
    FOREIGN KEY (patient_id) REFERENCES users(id),
    FOREIGN KEY (doctor_id) REFERENCES users(id)
);
```

#### **Bills Table**
```sql
CREATE TABLE bills (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    consultation_id BIGINT,
    total_amount DECIMAL(10,2) NOT NULL,
    payment_method ENUM('cash', 'mobile_money', 'card', 'insurance'),
    payment_status ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending',
    bill_type ENUM('consultation', 'medication', 'lab_test', 'other') DEFAULT 'consultation',
    cashier_id BIGINT,
    paid_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (consultation_id) REFERENCES consultations(id),
    FOREIGN KEY (cashier_id) REFERENCES users(id)
);
```

### **Relationships Overview**
```
Users (1) ←→ (N) Roles
Users (1) ←→ (N) Appointments (as Patient)
Users (1) ←→ (N) Appointments (as Doctor)
Users (1) ←→ (N) Consultations (as Patient)
Users (1) ←→ (N) Consultations (as Doctor)
Users (1) ←→ (N) Bills
Users (1) ←→ (N) Prescriptions (as Patient)
Users (1) ←→ (N) Prescriptions (as Doctor)

Appointments (1) ←→ (1) Consultations
Consultations (1) ←→ (N) Prescriptions
Prescriptions (1) ←→ (N) Prescription Items
Categories (1) ←→ (N) Drugs
```

---

## 🔌 API Documentation

### **Authentication Endpoints**

#### **POST /login**
```json
{
    "email": "user@example.com",
    "password": "password"
}
```

**Response:**
```json
{
    "success": true,
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "role": "doctor"
    },
    "redirect": "/dashboard"
}
```

#### **POST /logout**
```json
{
    "success": true,
    "message": "Logged out successfully"
}
```

### **Patient Endpoints**

#### **GET /api/patients**
```json
{
    "data": [
        {
            "id": 1,
            "name": "John Mugisha",
            "email": "john@example.com",
            "phone": "+256700000000",
            "appointments_count": 5,
            "last_visit": "2024-01-15"
        }
    ],
    "meta": {
        "total": 50,
        "per_page": 10,
        "current_page": 1
    }
}
```

#### **POST /api/patients**
```json
{
    "name": "New Patient",
    "email": "patient@example.com",
    "phone": "+256700000001",
    "address": "Kampala, Uganda",
    "date_of_birth": "1990-01-01"
}
```

### **Appointment Endpoints**

#### **GET /api/appointments**
```json
{
    "data": [
        {
            "id": 1,
            "patient": {
                "name": "John Mugisha",
                "phone": "+256700000000"
            },
            "doctor": {
                "name": "Dr. Sarah Nankya",
                "specialization": "General Medicine"
            },
            "appointment_date": "2024-01-20",
            "appointment_time": "10:30:00",
            "status": "confirmed",
            "reason": "Routine checkup"
        }
    ]
}
```

#### **POST /api/appointments**
```json
{
    "patient_id": 1,
    "doctor_id": 2,
    "appointment_date": "2024-01-25",
    "appointment_time": "14:00:00",
    "reason": "Follow-up consultation"
}
```

### **Error Response Format**
```json
{
    "success": false,
    "error": {
        "message": "Validation failed",
        "details": {
            "email": ["The email field is required."],
            "password": ["The password must be at least 8 characters."]
        }
    }
}
```

---

## 🔐 Security Implementation

### **Authentication & Authorization**
- **Laravel Sanctum**: API token-based authentication
- **Session-based Auth**: Web application authentication
- **Role-based Access Control**: Middleware for role permissions
- **CSRF Protection**: Cross-site request forgery prevention

### **Security Measures**
```php
// Password Hashing
Hash::make($password);

// Input Validation
$request->validate([
    'email' => 'required|email|unique:users',
    'password' => 'required|min:8|confirmed'
]);

// SQL Injection Prevention (Eloquent ORM)
User::where('email', $email)->first();

// XSS Protection (Blade Templates)
{{ $user->name }} // Auto-escaped

// CSRF Protection
@csrf // Token generation
```

### **Middleware Implementation**
```php
// Role-based middleware
Route::middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard']);
});

// Patient-specific middleware
Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/patient/dashboard', [PatientController::class, 'dashboard']);
});
```

### **Data Protection**
- **Encryption**: Sensitive data encryption at rest
- **Secure Headers**: HTTP security headers implementation
- **Rate Limiting**: API endpoint rate limiting
- **Input Sanitization**: User input sanitization and validation

---

## ⚡ Performance Optimization

### **Database Optimization**
```php
// Query Optimization
$appointments = Appointment::with(['patient', 'doctor'])
    ->where('appointment_date', '>=', today())
    ->orderBy('appointment_date')
    ->paginate(10);

// Index Optimization
Schema::table('appointments', function (Blueprint $table) {
    $table->index(['appointment_date', 'appointment_time']);
    $table->index('patient_id');
    $table->index('doctor_id');
});
```

### **Caching Strategy**
```php
// Route Caching
php artisan route:cache

// Configuration Caching
php artisan config:cache

// View Caching
php artisan view:cache

// Application Caching
Cache::remember('doctors_list', 3600, function () {
    return User::whereHas('role', function($q) {
        $q->where('name', 'doctor');
    })->get();
});
```

### **Frontend Optimization**
```javascript
// Lazy Loading Images
const imageObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.dataset.src;
            imageObserver.unobserve(img);
        }
    });
});

// Debounced Search
const debounceSearch = debounce((query) => {
    fetch(`/api/search?q=${query}`)
        .then(response => response.json())
        .then(data => renderResults(data));
}, 300);
```

---

## 👨‍💻 Development Guidelines

### **Code Standards**
```php
// Controller Method Structure
public function store(Request $request)
{
    // 1. Validation
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users'
    ]);

    // 2. Business Logic
    try {
        $user = User::create($validated);
        
        // 3. Response
        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully');
    } catch (\Exception $e) {
        return back()
            ->with('error', 'Failed to create user')
            ->withInput();
    }
}
```

### **Naming Conventions**
- **Models**: PascalCase (User, Patient, Appointment)
- **Controllers**: PascalCase + "Controller" (UserController)
- **Methods**: camelCase (getUserById, createAppointment)
- **Variables**: camelCase (userName, appointmentDate)
- **Database Tables**: snake_case (users, appointments, consultation_notes)

### **File Organization**
```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── PatientController.php
│   │   └── DoctorController.php
│   └── Middleware/
├── Models/
│   ├── User.php
│   ├── Patient.php
│   └── Appointment.php
├── Services/
│   ├── AppointmentService.php
│   └── BillingService.php
└── Providers/
```

---

## 🧪 Testing Strategy

### **Unit Testing**
```php
// Example Unit Test
class UserTest extends TestCase
{
    public function test_user_can_be_created()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123'
        ];

        $user = User::create($userData);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
    }
}
```

### **Feature Testing**
```php
// Example Feature Test
class AppointmentBookingTest extends TestCase
{
    public function test_patient_can_book_appointment()
    {
        $patient = User::factory()->create(['role_id' => 5]); // Patient role
        $doctor = User::factory()->create(['role_id' => 2]); // Doctor role

        $response = $this->actingAs($patient)
            ->post('/appointments', [
                'doctor_id' => $doctor->id,
                'appointment_date' => '2024-01-25',
                'appointment_time' => '10:00:00',
                'reason' => 'Routine checkup'
            ]);

        $response->assertRedirect('/appointments');
        $this->assertDatabaseHas('appointments', [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id
        ]);
    }
}
```

### **Testing Commands**
```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/AppointmentTest.php

# Generate test coverage report
php artisan test --coverage
```

---

## 🚀 Deployment Architecture

### **Production Environment Setup**
```yaml
# docker-compose.yml
version: '3.8'
services:
  app:
    build: .
    ports:
      - "8000:8000"
    environment:
      - APP_ENV=production
      - DB_HOST=mysql
      - REDIS_HOST=redis
    depends_on:
      - mysql
      - redis

  mysql:
    image: mysql:8.0
    environment:
      MYSQL_DATABASE: citycare
      MYSQL_ROOT_PASSWORD: secret
    volumes:
      - mysql_data:/var/lib/mysql

  redis:
    image: redis:7-alpine
    ports:
      - "6379:6379"

  nginx:
    image: nginx:alpine
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./nginx.conf:/etc/nginx/nginx.conf
    depends_on:
      - app
```

### **Environment Configuration**
```env
# Production Environment
APP_NAME=CityCare Medical Centre
APP_ENV=production
APP_KEY=base64:generated-key-here
APP_DEBUG=false
APP_URL=https://citycare.example.com

# Database
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=citycare
DB_USERNAME=citycare_user
DB_PASSWORD=secure_password

# Cache
CACHE_DRIVER=redis
REDIS_HOST=redis
REDIS_PORT=6379

# Queue
QUEUE_CONNECTION=redis

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=noreply@citycare.com
MAIL_PASSWORD=app_password
MAIL_ENCRYPTION=tls
```

### **Monitoring & Logging**
```php
// Custom Logging
Log::channel('appointments')->info('Appointment created', [
    'appointment_id' => $appointment->id,
    'patient_id' => $appointment->patient_id,
    'doctor_id' => $appointment->doctor_id
]);

// Error Monitoring
try {
    // Critical operation
} catch (\Exception $e) {
    Log::error('Operation failed', [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
    
    // Optional: Send to monitoring service
    // Sentry::captureException($e);
}
```

### **Backup Strategy**
```bash
#!/bin/bash
# Database Backup Script
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -h mysql -u citycare_user -psecure_password citycare > \
    /backups/citycare_$DATE.sql

# File Backup
tar -czf /backups/storage_$DATE.tar.gz storage/

# Cleanup old backups (keep 7 days)
find /backups -name "*.sql" -mtime +7 -delete
find /backups -name "*.tar.gz" -mtime +7 -delete
```

---

## 📊 Performance Metrics

### **Key Performance Indicators**
- **Response Time**: < 200ms for API endpoints
- **Page Load Time**: < 2 seconds for dashboard pages
- **Database Query Time**: < 100ms for optimized queries
- **Memory Usage**: < 256MB per request
- **CPU Usage**: < 50% under normal load

### **Monitoring Tools**
- **Laravel Telescope**: Application monitoring
- **New Relic**: Performance monitoring
- **Sentry**: Error tracking
- **Grafana**: Metrics visualization

---

**CityCare Medical Centre** - Technical Architecture Documentation  
*Last Updated: January 2024*  
*Version: 1.0*
