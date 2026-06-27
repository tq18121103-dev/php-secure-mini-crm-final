DROP DATABASE IF EXISTS secure_crm;

CREATE DATABASE secure_crm
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE secure_crm;

-- ======================
-- Users
-- ======================

CREATE TABLE users
(
    id INT AUTO_INCREMENT PRIMARY KEY,

    username VARCHAR(50) NOT NULL UNIQUE,

    password VARCHAR(255) NOT NULL,

    role ENUM('admin','staff')
    DEFAULT 'staff',

    created_at TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP
);

-- ======================
-- Leads
-- ======================

CREATE TABLE leads
(
    id INT AUTO_INCREMENT PRIMARY KEY,

    lead_code VARCHAR(30) NOT NULL UNIQUE,

    full_name VARCHAR(100) NOT NULL,

    email VARCHAR(150) NOT NULL UNIQUE,

    phone VARCHAR(30),

    source VARCHAR(100),

    status ENUM
    (
        'new',
        'contacted',
        'qualified',
        'lost',
        'customer'
    )
    DEFAULT 'new',

    created_at TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_lead_email
ON leads(email);

CREATE INDEX idx_lead_status
ON leads(status);

-- ======================
-- Orders
-- ======================

CREATE TABLE orders
(
    id INT AUTO_INCREMENT PRIMARY KEY,

    order_code VARCHAR(30) NOT NULL UNIQUE,

    lead_id INT NOT NULL,

    amount DECIMAL(12,2) NOT NULL,

    order_status ENUM
    (
        'pending',
        'paid',
        'cancelled'
    )
    DEFAULT 'pending',

    created_at TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_orders_leads
    FOREIGN KEY (lead_id)
    REFERENCES leads(id)
    ON DELETE CASCADE
);

CREATE INDEX idx_order_status
ON orders(order_status);

CREATE INDEX idx_order_code
ON orders(order_code);