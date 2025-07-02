# 💬 MightyChat – Flutter + Laravel Private Chat System for Fitness Platforms

MightyChat is a private 1-on-1 chat module designed for fitness platforms, enabling secure and exclusive communication between users and personal trainers. Built with **Laravel 12** and **Flutter**, it supports message and image exchange, chat history, and real-time updates.

---

## 🚀 Features

- 🔐 Private user <-> trainer communication
- 🖼️ Image and message exchange
- 🕓 Persistent chat history
- 🔔 Notifications for new messages
- 🔒 Exclusive access per user
- 📱 Optimized for mobile (Flutter)
- 🧠 Scalable backend with Laravel and MySQL

---

## 🛠️ Tech Stack

| Layer         | Technology          |
|---------------|---------------------|
| **Frontend**  | Flutter              |
| **Backend**   | Laravel 12 (PHP)     |
| **Database**  | MySQL                |
| **Optional**  | WebSockets / Firebase (for real-time) |

---

## 📂 Project Structure

backend/
└── app/
└── Http/
└── Controllers/Api/
flutter/
└── lib/
└── screens/
└── services/

---

## 🧪 Setup & Installation

### Backend (Laravel)

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve


Frontend (Flutter)

cd flutter
flutter pub get
flutter run

📢 Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.
