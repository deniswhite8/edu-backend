CREATE TABLE customers (
  customer_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  name        VARCHAR(255)
              COLLATE utf8_bin NULL,
  password    VARCHAR(32)
              COLLATE utf8_bin NOT NULL,
  rating      DECIMAL(10, 2)   NULL,
  quote_id    INT(11) UNSIGNED NOT NULL,

  PRIMARY KEY (customer_id)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;


CREATE TABLE addresses (
  address_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  city_id    INT(11) UNSIGNED,
  region_id  INT(11) UNSIGNED,
  zip_code   VARCHAR(255)
             COLLATE utf8_bin NULL,
  street     VARCHAR(255)
             COLLATE utf8_bin NULL,
  house      INT(6) UNSIGNED  NULL,
  flat       INT(6) UNSIGNED  NULL,

  PRIMARY KEY (address_id)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;


CREATE TABLE cities (
  city_id   INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  name      VARCHAR(255)
            COLLATE utf8_bin NULL,
  region_id INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (city_id)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;


CREATE TABLE regions (
  region_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  name      VARCHAR(255)
            COLLATE utf8_bin NULL,
  PRIMARY KEY (region_id)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;


CREATE TABLE quotes (
  quote_id             INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  address_id           INT(11) UNSIGNED NULL,
  shipping_method_code VARCHAR(16)
                       COLLATE utf8_bin NULL,
  payment_method_code  VARCHAR(16)
                       COLLATE utf8_bin NULL,
  shipping             INT(11) UNSIGNED NULL,
  subtotal             INT(11) UNSIGNED NULL,
  grand_total          INT(11) UNSIGNED NULL,
  PRIMARY KEY (quote_id)

)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;

CREATE TABLE quote_items (
  item_id    INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  product_id INT(11) UNSIGNED NOT NULL,
  qty        INT(11) UNSIGNED NULL,
  quote_id   INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (item_id)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;


CREATE TABLE orders (
  order_id             INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  created_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  customer_id          INT(11) UNSIGNED NULL,

# QUOTE DATA
  shipping_method_code VARCHAR(16)
                       COLLATE utf8_bin NULL,
  payment_method_code  VARCHAR(16)
                       COLLATE utf8_bin NULL,
  shipping             INT(11) UNSIGNED NULL,
  subtotal             INT(11) UNSIGNED NULL,
  grand_total          INT(11) UNSIGNED NULL,

# ADDRESS DATA
  city_name            VARCHAR(255)
                       COLLATE utf8_bin NULL,
  region_name          VARCHAR(255)
                       COLLATE utf8_bin NULL,
  zip_code             VARCHAR(255)
                       COLLATE utf8_bin NULL,
  street               VARCHAR(255)
                       COLLATE utf8_bin NULL,
  house                INT(6) UNSIGNED  NULL,
  flat                 INT(6) UNSIGNED  NULL,


  PRIMARY KEY (order_id)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;


CREATE TABLE products_order (
  products_order_id INT(11) UNSIGNED        NOT NULL AUTO_INCREMENT,
  order_id       INT(11) UNSIGNED        NOT NULL,

  qty            INT(11) UNSIGNED        NULL,

# PRODUCT DATA
  name           VARCHAR(255)
                 COLLATE utf8_bin        NULL,
  sku            VARCHAR(255)
                 COLLATE utf8_bin        NULL,
  price          DECIMAL(10, 2) UNSIGNED NOT NULL,
  special_price  DECIMAL(10, 2) UNSIGNED NULL,

  PRIMARY KEY (products_order_id)
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


CREATE TABLE reviews (
  review_id  INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  rating     INT(1) UNSIGNED  NOT NULL,
  text       VARCHAR(2047)
             COLLATE utf8_bin NULL,

  product_id INT(11) UNSIGNED NOT NULL,
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

# ALTER TABLE shopping_cart
# ADD FOREIGN KEY (customer_id)
# REFERENCES customers (customer_id)
#   ON DELETE CASCADE
#   ON UPDATE CASCADE;
#
# ALTER TABLE shopping_cart
# ADD FOREIGN KEY (product_id)
# REFERENCES products (product_id)
#   ON DELETE CASCADE
#   ON UPDATE CASCADE;

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

INSERT INTO regions (name)
  VALUES ('USA'), ('Russia');
INSERT INTO cities (name, region_id)
  VALUES ('NY', 1), ('Moscow', 2), ('Taganrog', 2);