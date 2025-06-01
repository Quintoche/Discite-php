DROP TABLE IF EXISTS disciteDB_FakeItemSuppliers;
DROP TABLE IF EXISTS disciteDB_FakeItems;
DROP TABLE IF EXISTS disciteDB_FakeCategories;
DROP TABLE IF EXISTS disciteDB_FakeSuppliers;

CREATE TABLE disciteDB_FakeCategories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL
);

CREATE TABLE disciteDB_FakeSuppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    supplier_name VARCHAR(100) NOT NULL,
    contact_email VARCHAR(100)
);

CREATE TABLE disciteDB_FakeItems (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price FLOAT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES disciteDB_FakeCategories(id)
);

CREATE TABLE disciteDB_FakeItemSuppliers (
    item_id INT NOT NULL,
    supplier_id INT NOT NULL,
    PRIMARY KEY (item_id, supplier_id),
    FOREIGN KEY (supplier_id) REFERENCES disciteDB_FakeSuppliers(id)
);

-- Categories
INSERT INTO disciteDB_FakeCategories (category_name) VALUES
('Widgets'),
('Gadgets'),
('Accessories');

-- Suppliers
INSERT INTO disciteDB_FakeSuppliers (supplier_name, contact_email) VALUES
('Supplier A', 'contact@supplierA.com'),
('Supplier B', 'sales@supplierB.com'),
('Supplier C', 'info@supplierC.com');

-- Items with category_id
INSERT INTO disciteDB_FakeItems (category_id, name, description, price) VALUES
(1, 'Blue Widget', 'A small blue widget for testing.', 10.99),
(1, 'Red Widget', 'A slightly larger red widget.', 15.49),
(1, 'Green Widget', 'A stylish green widget.', 13.75),
(2, 'Yellow Gadget', 'Bright and bold gadget.', 9.99),
(2, 'Black Gadget', 'Elegant and discreet gadget.', 12.25),
(3, 'Silver Accessory', 'Sleek and shiny accessory.', 16.45),
(3, 'Golden Accessory', 'Premium edition accessory.', 22.99),
(1, 'Tiny Widget', 'Miniature and cute.', 7.49),
(1, 'Giant Widget', 'For heavy-duty needs.', 25.00),
(3, 'Budget Accessory', 'Cheap and cheerful.', 5.99),
(2, 'Luxury Gadget', 'Top-tier quality.', 29.99),
(3, 'Limited Accessory', 'Rare and collectible.', 19.99);

-- Many-to-many item-supplier links
INSERT INTO disciteDB_FakeItemSuppliers (item_id, supplier_id) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 3),
(4, 2),
(5, 2),
(6, 3),
(7, 1),
(8, 3),
(9, 1),
(10, 2),
(11, 3),
(12, 1);
