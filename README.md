# 🚀 Food Delivery App (Backend API System)

<p align="center">
  <h2 align="center">Scalable Multi-Role Backend for a Real-World Food Delivery Platform</h2>
</p>

---

## 📌 Overview

This project is a **production-grade backend API system** for a Food Delivery Application, developed using **Laravel**.

It was built for an international client (India) and powers **two separate mobile applications**:

* 📱 Customer App (Flutter)
* 🚴 Delivery Partner App (Flutter)

Along with a **centralized Admin Dashboard**, the backend handles complete operational workflows of a real-world food delivery business.

---

## 🧠 Backend Engineering Highlights

* Designed full **RESTful API architecture** for multiple client applications
* Built **multi-role system** (Customer, Delivery Boy, Admin)
* Implemented **order lifecycle management system**
* Developed **delivery assignment and shift management logic**
* Created **scalable and modular backend structure**
* Optimized database queries for performance and reliability

---

## ⚙️ Core System Features

### 👤 Customer App APIs

* User registration & authentication
* Browse food categories & products
* Add to cart & place orders
* Order tracking system
* Address & profile management

---

### 🚴 Delivery Partner APIs

* Delivery partner registration & approval
* Shift management system
* Assigned order tracking
* Delivery status updates
* Earnings and activity tracking

---

### 🛠️ Admin Dashboard APIs

* Full system control panel
* Category & product management
* Order monitoring & control
* Delivery partner approval system
* Assign delivery shifts
* Assign orders to delivery partners
* Platform-level operations management

---

## 🔄 Order Workflow (System Design)

1. Customer places an order
2. Order is processed by the system
3. Admin assigns delivery boy 
4. Delivery boy accepts and delivers
5. Order status updates in real-time

---

## 🧩 API Architecture

* RESTful API design
* Token-based authentication system
* Structured controller-service pattern
* Modular route organization
* JSON response standardization

---

## 🗄️ Tech Stack

**Backend:**

* Laravel (PHP)

**Frontend (Client Apps):**

* Flutter (Mobile Applications)

**Database:**

* MySQL

**Tools & Practices:**

* Git version control
* Postman for API testing
* Environment-based configuration (.env)

---

## 🚀 Installation Guide

### 1️⃣ Clone the repository

```bash id="9q9yvx"
git clone https://github.com/faheem2407/Food-Delivery-App-Backend.git
```

### 2️⃣ Navigate to project directory

```bash id="l5h2jk"
cd Food-Delivery-App-Backend
```

### 3️⃣ Install dependencies

```bash id="f4l2wo"
composer update
```

### 4️⃣ Configure environment

Update your `.env` file:

```env id="d4z1h3"
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

---

### 5️⃣ Generate application key

```bash id="l2ks90"
php artisan key:generate
```

### 6️⃣ Run migrations & seeders

```bash id="r8x1nb"
php artisan migrate:fresh --seed
```

### 7️⃣ Clear cache

```bash id="m9z2qp"
php artisan optimize:clear
```

### 8️⃣ Start development server

```bash id="x2v9kl"
php artisan serve
```

---

## 🔐 Admin Access

**Admin Panel URL:**
http://127.0.0.1:8000/

**Credentials:**
Email: `admin@admin.com`
Password: `12345678`

---

## 👨‍💻 Contributor

**MD. ABED HASAN FAHIM**
Backend Engineer (Laravel API Specialist)

GitHub: https://github.com/faheem2407

---

## 🎯 Engineering Philosophy

* Build systems, not just APIs
* Clean architecture over quick fixes
* Scalable backend design from day one
* Real-world business logic implementation
* Maintainability and performance first

---

⭐ If you find this project useful, consider giving it a star!
