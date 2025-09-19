CREATE DATABASE travel_db;


USE travel_db;


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE active_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);


CREATE TABLE bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,  -- relation with users table (optional if guest booking allowed)
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    mobile VARCHAR(20) NOT NULL,
    age INT NOT NULL,
    gender ENUM('Male','Female','Other') NOT NULL,
    address TEXT NOT NULL,
    birth_date DATE NOT NULL,
    boarding VARCHAR(100) NOT NULL,
    destination VARCHAR(100) NOT NULL,
    travel_date DATE NOT NULL,
    price INT NOT NULL,
    payment_id VARCHAR(100),
    payment_status ENUM('pending','success','failed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);


---/// api key= rzp_test_REge0eBKuIICBL



-- CREATE TABLE bookings (
--     booking_id INT AUTO_INCREMENT PRIMARY KEY,
--     user_id INT,  -- relation with users table
--     name VARCHAR(100) NOT NULL,
--     email VARCHAR(150) NOT NULL,
--     mobile VARCHAR(15) NOT NULL,
--     age INT NOT NULL,
--     gender ENUM('Male','Female','Other') NOT NULL,
--     address TEXT NOT NULL,
--     birth_date DATE NOT NULL,
--     boarding VARCHAR(100) NOT NULL,
--     destination VARCHAR(100) NOT NULL,
--     travel_date DATE NOT NULL,
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
-- );

