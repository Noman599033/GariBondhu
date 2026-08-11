# Gari Bondhu - Premium Car Rental System

Welcome to **Gari Bondhu**! 👋 

This is a comprehensive car rental web application I built as a **Beginner Professional** to showcase my backend and frontend development skills using Laravel. My goal was to create a production-like application that solves a real-world problem while maintaining clean code, a modern user interface, and robust functionality.

## 🎯 About This Project & My Learning Journey

As an entry-level developer, building this project allowed me to dive deep into:
- **Full-Stack Development:** Integrating a Laravel backend with a dynamic, reactive frontend (Vue.js & Blade).
- **Database Architecture:** Designing relational databases for users, vehicles, bookings, and notifications.
- **Authentication & Authorization:** Managing separate guards for Admin and Customer roles.
- **Modern UI/UX:** Implementing Glassmorphism, Bootstrap 5, Dark/Light modes, and bilingual support (EN/BN) to ensure a premium user experience.

## 🚀 Key Features

### 🛒 Customer Portal
- **Smart Search:** Find vehicles based on rental duration (hourly, daily, weekly, monthly), pickup, and drop-off locations.
- **Customer Dashboard:** A dedicated portal for registered users to manage bookings, view rental statuses, and submit payments.
- **Real-time Notifications:** In-app notification bell alerting users when their booking status changes.

### ⚙️ Admin Panel
- **Fleet Management:** Add, edit, and manage vehicles, pricing tiers, and availability.
- **Booking & Payment Management:** Review incoming booking requests, update statuses, and verify manual payments (bKash / Bank Transfer).
- **Admin Notifications:** Instantly receive alerts when new bookings are placed or payments are submitted.

### 🎨 Global Features
- **Multilingual Support:** One-click toggle between English (EN) and Bengali (BN).
- **Dark/Light Mode:** Integrated theme switcher for a comfortable viewing experience.

## 🛠️ Technology Stack
- **Backend:** PHP 8.2+, Laravel (v10 / v11)
- **Frontend:** Bootstrap 5, Vue.js, Blade Templating
- **Database:** MySQL
- **Styling:** Custom CSS (Glassmorphism) & Bootstrap Icons

## 🔧 Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/yourusername/gari-bondhu.git
   cd gari-bondhu
   ```

2. **Install PHP Dependencies:**
   ```bash
   composer install
   ```

3. **Environment Setup:**
   Copy the example environment file and configure your database credentials.
   ```bash
   cp .env.example .env
   ```
   *Update `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in the `.env` file.*

4. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

5. **Run Migrations & Seeders:**
   ```bash
   php artisan migrate --seed
   ```

6. **Serve the Application:**
   ```bash
   php artisan serve
   ```
   *The application will be accessible at `http://localhost:8000`.*

## 📈 Future Improvements
Since I am continuously learning and improving, here are a few things I plan to add in the future:
- Integration of a fully automated payment gateway (e.g., Stripe, SSLCommerz).
- Email verification and automated email receipts.
- A REST API to support a future mobile application.

## 🤝 Let's Connect!
I am actively looking for opportunities to grow as a professional developer. If you have feedback on my code or want to discuss a potential role, feel free to reach out!

---
*Built with ❤️ and Laravel.*
