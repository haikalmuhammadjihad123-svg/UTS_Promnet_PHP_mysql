-- Database: db_kost
CREATE DATABASE IF NOT EXISTS db_kost;
USE db_kost;

-- Tabel User untuk Login Admin
CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Data Default Admin (username: admin, password: admin123)
INSERT INTO user (username, password) VALUES 
('admin', '$2y$10$KiB0XSj5ZlJmN8jkGRwE0OwYCPK6hfWpam7T9OCY33wzcjqjbc0T2');

-- Tabel Kamar Kos
CREATE TABLE IF NOT EXISTS kamar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nomor_kamar VARCHAR(50) NOT NULL,
    tipe VARCHAR(50) NOT NULL,
    harga INT NOT NULL,
    fasilitas VARCHAR(255) NOT NULL,
    gambar VARCHAR(255) NOT NULL
);

-- Data Dummy Kamar Kos (untuk pengujian pagination)
INSERT INTO kamar (nomor_kamar, tipe, harga, fasilitas, gambar) VALUES
('Kamar 101', 'Standard', 750000, 'Kasur, Lemari, WiFi, Kamar Mandi Luar', 'kamar-A101.jpg'),
('Kamar 102', 'Deluxe', 1200000, 'AC, Kasur Springbed, Kamar Mandi Dalam, WiFi', 'kamar-A102.jpg'),
('Kamar 103', 'Standard', 800000, 'Kasur, Lemari, Meja Belajar, Kipas Angin', 'kamar-A103.jpg'),
('Kamar 201', 'VIP', 1700000, 'AC, Smart TV, Water Heater, Kamar Mandi Dalam, Kulkas', 'kamar-B201.jpg'),
('Kamar 202', 'Deluxe', 1300000, 'AC, Kasur, Lemari 2 Pintu, Meja Kerja, KM Dalam', 'kamar-B202.jpg'),
('Kamar 203', 'VIP', 1900000, 'AC, Balkon Pribadi, Springbed King, Kamar Mandi Dalam', 'kamar-VIP01.jpg');
