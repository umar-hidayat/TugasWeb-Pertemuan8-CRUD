CREATE DATABASE IF NOT EXISTS inventaris_db;
USE inventaris_db;

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    category_id INT NOT NULL,
    supplier_id INT NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO categories (name) VALUES 
('Aksesoris'), ('Display'), ('Komponen'), ('Periferal'), ('Penyimpanan');

INSERT INTO suppliers (name, phone) VALUES 
('PT Logitek Indonesia', '081234567890'),
('CV Asus Tech', '081987654321'),
('PT Samsung Electronics', '082111223344'),
('Distributor MSI', '085299887766'),
('PT Kingston Official', '087755443322');

INSERT INTO products (name, category_id, supplier_id, price, stock) VALUES 
('Mouse Wireless MX Master 3S', 1, 1, 1500000.00, 15),
('Monitor Gaming 24 Inch 144Hz', 2, 3, 2300000.00, 8),
('Keyboard Mechanical RGB', 1, 2, 850000.00, 20),
('SSD NVMe 1TB', 5, 5, 1200000.00, 12),
('Kartu Grafis RTX 4060', 3, 4, 5100000.00, 5);