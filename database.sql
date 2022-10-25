CREATE SCHEMA pix_project_db;

USE pix_project_db;

CREATE TABLE IF NOT EXISTS users (
  id INT(11) NOT NULL AUTO_INCREMENT,
  email VARCHAR(70) NOT NULL UNIQUE,
  password VARCHAR(400) NOT NULL,
  fullname CHAR(70) NOT NULL,
  dni CHAR(15) NOT NULL,
  numberPhone CHAR(15) NULL,
  address VARCHAR(100) NULL,
  isAdmin BOOLEAN DEFAULT false,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS products (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name CHAR(50) NOT NULL,
  price FLOAT NOT NULL,
  image VARCHAR(500) NOT NULL,
  stock INT(11) NOT NULL,
  userId INT(11) NULL,
  PRIMARY KEY (id),
  INDEX (userId)
);

CREATE TABLE IF NOT EXISTS user_products (
  userId INT(11) NULL,
  productId INT(11) NULL,
  INDEX (userId),
  INDEX (productId)
);

ALTER TABLE products ADD FOREIGN KEY (userId) REFERENCES users (id);
ALTER TABLE user_products ADD FOREIGN KEY (userId) REFERENCES users (id);
ALTER TABLE user_products ADD FOREIGN KEY (productId) REFERENCES products (id);