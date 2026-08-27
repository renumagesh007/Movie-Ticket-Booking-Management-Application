# 🎬 CineBook — Movie Ticket Booking Management System

A full-featured movie ticket booking web application built with **HTML, CSS, JavaScript-free PHP (server-rendered), and MySQL**.

## Features

### User side
- Register / Login (secure password hashing with `password_hash`)
- Browse "Now Showing" movies, search by title, filter by genre
- View movie details and available showtimes
- Book tickets (choose number of seats + optional seat numbers)
- Seat availability is updated safely using a database transaction
- View "My Bookings" and cancel a booking (seats are released back)

### Admin side
- Dashboard with stats: total movies, showtimes, confirmed bookings, total revenue
- Add / Edit / Delete movies
- Add / Delete showtimes (linked to a movie, date, time, hall, seat count)
- View all bookings made by all users

## Tech Stack
- **Frontend:** HTML5, CSS3 (custom, no framework)
- **Backend:** PHP (procedural, `mysqli` with prepared statements)
- **Database:** MySQL

## Project Structure
```
movie_ticket_booking/
├── db.sql                 # database schema + sample data
├── config.php              # DB connection + session helpers
├── index.php                # movie listing / homepage
├── movie.php                # movie details + showtimes
├── book.php                 # ticket booking
├── my_bookings.php          # user's bookings + cancel
├── cancel_booking.php
├── register.php / login.php / logout.php
├── css/style.css
├── includes/header.php, footer.php
└── admin/
    ├── dashboard.php
    ├── movies.php / add_movie.php / edit_movie.php / delete_movie.php
    ├── showtimes.php / add_showtime.php / delete_showtime.php
    └── bookings.php
```

## Setup Instructions (XAMPP / WAMP / LAMP)

1. **Install a local server stack** such as XAMPP (includes PHP + MySQL + Apache).
2. Copy the `movie_ticket_booking` folder into your server's web root:
   - XAMPP (Windows): `C:\xampp\htdocs\movie_ticket_booking`
   - XAMPP (Mac/Linux): `/opt/lampp/htdocs/movie_ticket_booking`
3. Start **Apache** and **MySQL** from the XAMPP control panel.
4. Open **phpMyAdmin** (`http://localhost/phpmyadmin`), create the database by importing `db.sql`
   (this also creates sample movies and showtimes).
5. Open `config.php` and confirm the DB credentials match your MySQL setup
   (defaults: user `root`, no password — standard for XAMPP).
6. Visit `http://localhost/movie_ticket_booking/index.php` in your browser.

## Creating an Admin Account
1. Register a normal account via the **Register** page.
2. In phpMyAdmin, run:
   ```sql
   UPDATE users SET role='admin' WHERE email='youremail@example.com';
   ```
3. Log out and log back in — you'll now see an **Admin Panel** link and be
   redirected to the dashboard automatically on login.

## Database Schema (summary)
- **users**(id, name, email, password, role, created_at)
- **movies**(id, title, description, genre, language, duration_minutes, poster_url, price, created_at)
- **showtimes**(id, movie_id → movies, show_date, show_time, hall, total_seats, available_seats)
- **bookings**(id, user_id → users, showtime_id → showtimes, seats_booked, seat_numbers, total_amount, status, booking_date)

## Notes for Presentation / Viva
- Passwords are never stored in plain text (`password_hash` / `password_verify`).
- All SQL queries use **prepared statements** to prevent SQL injection.
- Seat booking uses a **transaction** (`begin_transaction` / `commit` / `rollback`) so two users
  can't overbook the same seats.
- Role-based access control separates normal users from admins (`isAdmin()` helper).
- This project can be extended with: payment gateway integration, seat-map UI, email
  confirmations, and QR-code tickets.
