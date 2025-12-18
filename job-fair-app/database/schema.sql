-- Job Fair Database Schema
-- Created for Front-End Developer Practical Test

-- Create database
CREATE DATABASE IF NOT EXISTS job_fair_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE job_fair_db;

-- Table: contacts
-- Stores contact form submissions
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: exhibitors
-- Stores exhibitor registration data
CREATE TABLE IF NOT EXISTS exhibitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(255) NOT NULL,
    contact_person VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    industry VARCHAR(100),
    booth_preference VARCHAR(50),
    additional_info TEXT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: reservations
-- Stores job matching and career talk session reservations
CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    reservation_type ENUM('job_matching', 'career_talk') NOT NULL,
    session_date DATE NOT NULL,
    session_time TIME NOT NULL,
    additional_notes TEXT,
    status ENUM('confirmed', 'cancelled', 'completed') DEFAULT 'confirmed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_reservation (email, reservation_type, session_date, session_time),
    INDEX idx_email (email),
    INDEX idx_session_date (session_date),
    INDEX idx_reservation_type (reservation_type),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample data for testing (optional)
-- Uncomment the lines below if you want sample data

-- INSERT INTO contacts (name, email, phone, message) VALUES
-- ('John Doe', 'john@example.com', '+60123456789', 'I am interested in attending the job fair.'),
-- ('Jane Smith', 'jane@example.com', '+60198765432', 'Can I get more information about the exhibitors?');

-- INSERT INTO exhibitors (company_name, contact_person, email, phone, industry, booth_preference) VALUES
-- ('Tech Solutions Sdn Bhd', 'Ahmad bin Ali', 'ahmad@techsolutions.com', '+60321234567', 'Technology', 'Corner Booth'),
-- ('Marketing Pro', 'Siti Nurhaliza', 'siti@marketingpro.com', '+60387654321', 'Marketing', 'Standard Booth');
