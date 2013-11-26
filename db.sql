CREATE TABLE customers (
  customer_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  name        VARCHAR(255)
              COLLATE utf8_bin NULL,
  rating      DECIMAL(10, 2)   NULL,

  PRIMARY KEY (customer_id)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;

CREATE TABLE sellers (
  seller_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  name      VARCHAR(255)
            COLLATE utf8_bin NULL,
  city      VARCHAR(255)
            COLLATE utf8_bin NULL,
  comission DECIMAL(10, 2)   NULL,

  PRIMARY KEY (seller_id)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;

CREATE TABLE orders (
  order_id    INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  created_at  DATETIME         NULL,
  amount      DECIMAL(10, 2)   NULL,
  customer_id INT(11) UNSIGNED NOT NULL,
  seller_id   INT(11) UNSIGNED NOT NULL,

  PRIMARY KEY (order_id)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;

CREATE TABLE products (
  product_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  name       VARCHAR(255)
             COLLATE utf8_bin NULL,
  sku        VARCHAR(255)
             COLLATE utf8_bin NULL,

  PRIMARY KEY (product_id)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;


CREATE TABLE order_products (
  link_id    INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  product_id INT(11) UNSIGNED NOT NULL,
  order_id   INT(11) UNSIGNED NOT NULL,

  PRIMARY KEY (link_id)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;


CREATE TABLE reviews (
  review_id    INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  rating INT(1) UNSIGNED NOT NULL,
  text VARCHAR(2047)
       COLLATE utf8_bin NULL,

  product_id INT(11) UNSIGNED NOT NULL,
  customer_id INT(11) UNSIGNED NOT NULL,

  PRIMARY KEY (review_id)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;






-- homework

ALTER TABLE products
ADD UNIQUE INDEX (sku);


ALTER TABLE orders
ADD FOREIGN KEY (customer_id)
REFERENCES customers (customer_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;


ALTER TABLE orders
ADD FOREIGN KEY (seller_id)
REFERENCES sellers (seller_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;


ALTER TABLE order_products
ADD FOREIGN KEY (product_id)
REFERENCES products (product_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;


ALTER TABLE order_products
ADD FOREIGN KEY (order_id)
REFERENCES orders (order_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;


ALTER TABLE reviews
ADD FOREIGN KEY (customer_id)
REFERENCES customers (customer_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;


ALTER TABLE reviews
ADD FOREIGN KEY (product_id)
REFERENCES products (product_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;


-- test
# INSERT INTO customers (name) VALUES ('Petya');
# INSERT INTO sellers (name) VALUES ('Vasya');
# INSERT INTO orders (customer_id, seller_id) VALUES (1, 1);
# INSERT INTO products (name, sku) VALUES ('Nokia', '12345');
# INSERT INTO order_products (product_id, order_id) VALUES (1, 1);
# INSERT INTO reviews (customer_id, product_id, rating, text) VALUES (1, 1, 1, 'bad'), (1, 2, 5, 'good');


# CREATE TABLE abstract_collection (id INT(11) DEFAULT NULL, data VARCHAR(100) DEFAULT NULL)
#   ENGINE=InnoDB
#   DEFAULT CHARSET=latin1;
