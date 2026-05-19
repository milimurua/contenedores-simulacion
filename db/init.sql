USE inventario;

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    categoria VARCHAR(50)  NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO productos (nombre, categoria, precio, stock) VALUES
('Hamburguesa', 'Comida', 1299.99, 15),
('Lomo', 'Comida', 399.99, 30),
('Empenadas', 'Comida', 89.99, 50),
('Pasta','Comida', 99.99, 45),
('Coca Cola', 'Bebidas', 119.99, 60),
('Fanta', 'Bebidas', 149.99, 25),
('Jugo', 'Bebidas', 89.99, 40),
('Ensalada', 'Comida', 99.99, 20);
