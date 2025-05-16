DROP TABLE IF EXISTS disciteDB_FakeItems;

CREATE TABLE disciteDB_FakeItems (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price FLOAT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO disciteDB_FakeItems (name, description, price) VALUES
('Blue Widget', 'A small blue widget for testing.', 10.99),
('Red Widget', 'A slightly larger red widget.', 15.49),
('Green Widget', 'A stylish green widget.', 13.75),
('Yellow Widget', 'Bright and bold.', 9.99),
('Black Widget', 'Elegant and discreet.', 12.25),
('White Widget', 'Clean and pure design.', 11.00),
('Silver Widget', 'Sleek and shiny.', 16.45),
('Golden Widget', 'Premium edition.', 22.99),
('Tiny Widget', 'Miniature and cute.', 7.49),
('Giant Widget', 'For heavy-duty needs.', 25.00),
('Budget Widget', 'Cheap and cheerful.', 5.99),
('Luxury Widget', 'Top-tier quality.', 29.99),
('Limited Widget', 'Rare and collectible.', 19.99),
('Smart Widget', 'Connected and smart.', 24.49),
('Eco Widget', 'Eco-friendly build.', 13.00),
('Classic Widget', 'Timeless style.', 14.50),
('Future Widget', 'Cutting-edge tech.', 28.00),
('Retro Widget', 'Vintage vibes.', 12.75),
('Mini Widget', 'Pocket-sized.', 8.99),
('Mega Widget', 'Extra large version.', 26.50);

