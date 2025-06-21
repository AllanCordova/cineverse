-- initdb/init.sql

CREATE DATABASE IF NOT EXISTS movies_db
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE USER IF NOT EXISTS 'user'@'%'
    IDENTIFIED BY 'userpass';

GRANT ALL PRIVILEGES ON movies_db.* TO 'user'@'%';

USE movies_db;

CREATE TABLE IF NOT EXISTS movies (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  director VARCHAR(255),
  year INT,
  genre VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
