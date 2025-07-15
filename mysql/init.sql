-- Create database if it does not exists.
CREATE DATABASE IF NOT EXISTS mydatabase;

-- Use this database.
USE mydatabase;

-- Create user and grant privileges.
CREATE USER IF NOT EXISTS 'admin'@'%' IDENTIFIED BY 'admin123';
GRANT ALL PRIVILEGES ON mydatabase.* TO 'admin'@'%';
FLUSH PRIVILEGES;

-- Create a sample table.
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert some initial data (optional)
INSERT INTO messages (message) VALUES ('Welcome to the MySQL database!');
INSERT INTO messages (message) VALUES ('This is a test message.');
