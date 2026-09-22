-- =========================================================
-- Student Event Registration System
-- Database: student_registration
-- =========================================================

CREATE DATABASE IF NOT EXISTS student_registration;
USE student_registration;

-- ---------------------------------------------------------
-- Table: events
-- Stores every event students can register for
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(150) NOT NULL,
    event_description TEXT,
    event_date DATE NOT NULL,
    event_venue VARCHAR(150),
    event_image VARCHAR(255) DEFAULT 'default-event.jpg',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ---------------------------------------------------------
-- Table: registrations
-- Stores every student registration, linked to an event
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS registrations (
    registration_id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    admission_number VARCHAR(30) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    course VARCHAR(100) NOT NULL,
    event_id INT NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(event_id) ON DELETE CASCADE
);
