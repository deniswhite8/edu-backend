CREATE TABLE customers (
  customer_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  name        VARCHAR(255)
              COLLATE utf8_bin NULL,
  password    VARCHAR(32)
              COLLATE utf8_bin NOT NULL,
  rating      DECIMAL(10, 2)   NULL,

  PRIMARY KEY (customer_id)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;


CREATE TABLE shopping_cart (
  shopping_cart_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  customer_id      INT(11) UNSIGNED NULL,
  product_id       INT(11) UNSIGNED NOT NULL,
  count            INT(11) UNSIGNED NULL,
  session_id       VARCHAR(64)
                   COLLATE utf8_bin NULL,

  PRIMARY KEY (shopping_cart_id)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;


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
  product_id    INT(11) UNSIGNED        NOT NULL AUTO_INCREMENT,
  name          VARCHAR(255)
                COLLATE utf8_bin        NULL,
  sku           VARCHAR(255)
                COLLATE utf8_bin        NULL,
  price         DECIMAL(10, 2) UNSIGNED NOT NULL,
  special_price DECIMAL(10, 2) UNSIGNED NULL,
  image         VARCHAR(255)
                COLLATE utf8_bin        NULL,

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
  review_id  INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  rating     INT(1) UNSIGNED  NOT NULL,
  text       VARCHAR(2047)
             COLLATE utf8_bin NULL,

  product_id INT(11) UNSIGNED NOT NULL,
#   customer_id INT(11) UNSIGNED NOT NULL,
  email      VARCHAR(128)
             COLLATE utf8_bin NULL,
  name       VARCHAR(128)
             COLLATE utf8_bin NULL,

  PRIMARY KEY (review_id)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;


-- homework

ALTER TABLE products
ADD UNIQUE INDEX (sku);

ALTER TABLE customers
ADD UNIQUE INDEX (name);


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

ALTER TABLE shopping_cart
ADD FOREIGN KEY (customer_id)
REFERENCES customers (customer_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE shopping_cart
ADD FOREIGN KEY (product_id)
REFERENCES products (product_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

# ALTER TABLE reviews
# ADD FOREIGN KEY (customer_id)
# REFERENCES customers (customer_id)
#   ON DELETE CASCADE
#   ON UPDATE CASCADE;
#
#
# ALTER TABLE reviews
# ADD FOREIGN KEY (product_id)
# REFERENCES products (product_id)
#   ON DELETE CASCADE
#   ON UPDATE CASCADE;


-- test
# INSERT INTO customers (name) VALUES ('Petya');
# INSERT INTO sellers (name) VALUES ('Vasya');
# INSERT INTO orders (customer_id, seller_id) VALUES (1, 1);
INSERT INTO products (name, sku, price, special_price, image)
  VALUES ('Nokia', '12345', 100.00, 0.00, 'http://www.qosc.zp.ua/wp-content/uploads/2013/08/Nokia_3310.jpg'),
  ('SE', '3242', 50.00, 48.99, 'http://freemarket.kiev.ua/images_goods/Sony-Ericsson/Sony-Ericsson-K320i-6.jpg');
# INSERT INTO order_products (product_id, order_id) VALUES (1, 1);
INSERT INTO reviews (product_id, rating, text, name)
  VALUES (1, 1, 'bad', 'lolka'), (2, 5, 'good', 'petrovich'), (1, 2, 'no', 'qwerty');
