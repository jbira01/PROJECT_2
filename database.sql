-- Create the vehicles table
CREATE TABLE IF NOT EXISTS vehicules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    make VARCHAR(255) NOT NULL,
    model VARCHAR(255) NOT NULL,
    year INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    category VARCHAR(50) NOT NULL,
    price_per_day DECIMAL(10, 2) NOT NULL,
    availability BOOLEAN DEFAULT TRUE
);

-- Create the reservations table
CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pickup_location VARCHAR(255) NOT NULL,
    start_date DATE NOT NULL,
    rental_duration INT NOT NULL,
    vehicule_id INT,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    FOREIGN KEY (vehicule_id) REFERENCES vehicules(id)
);

INSERT INTO vehicules (make, model, year, image_url, category, price_per_day, availability) VALUES
('Citroen', 'Clio', 2024, 'clio.png', 'compact', 50.00, 1),
('Honda', 'Vol', 2024, 'vol.png', 'compact', 55.00, 1),
('BMW', 'M3', 2024, 'bmw.png', 'luxe', 120.00, 1),
('Mercedes', 'Classe C', 2024, 'mercedes.png', 'luxe', 115.00, 1),
('Peugeot', '308', 2024, 'peugeot.png', 'luxe', 130.00, 1);