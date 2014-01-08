CREATE TABLE customers (
  customer_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  name        VARCHAR(255)
              COLLATE utf8_bin NULL,
  surname     VARCHAR(255)
              COLLATE utf8_bin NULL,
  email       VARCHAR(255)
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


CREATE TABLE admins (
  admin_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  login        VARCHAR(255)
              COLLATE utf8_bin NULL,
  password    VARCHAR(32)
              COLLATE utf8_bin NOT NULL,

  PRIMARY KEY (admin_id)
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
  order_id          INT(11) UNSIGNED        NOT NULL,

  qty               INT(11) UNSIGNED        NULL,

# PRODUCT DATA
  name              VARCHAR(255)
                    COLLATE utf8_bin        NULL,
  sku               VARCHAR(255)
                    COLLATE utf8_bin        NULL,
  price             DECIMAL(10, 2) UNSIGNED NOT NULL,
  special_price     DECIMAL(10, 2) UNSIGNED NULL,

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
ADD UNIQUE INDEX (email);

ALTER TABLE admins
ADD UNIQUE INDEX (login);

ALTER TABLE orders
ADD FOREIGN KEY (customer_id)
REFERENCES customers (customer_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;


ALTER TABLE orders
ADD FOREIGN KEY (customer_id)
REFERENCES customers (customer_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;


ALTER TABLE products_order
ADD FOREIGN KEY (order_id)
REFERENCES orders (order_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;


ALTER TABLE reviews
ADD FOREIGN KEY (product_id)
REFERENCES products (product_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;


ALTER TABLE quote_items
ADD FOREIGN KEY (product_id)
REFERENCES products (product_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE quote_items
ADD FOREIGN KEY (quote_id)
REFERENCES quotes (quote_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;



# FOR EXAMPLE

INSERT INTO products (name, sku, price, special_price, image)
  VALUES ('Nokia', '12345', 100.00, 0.00, 'http://www.qosc.zp.ua/wp-content/uploads/2013/08/Nokia_3310.jpg'),
  ('SE', '666', 50.00, 48.99, 'http://freemarket.kiev.ua/images_goods/Sony-Ericsson/Sony-Ericsson-K320i-6.jpg'),
  ('Siemens', '1337', 1.00, 0.99, 'http://www.mo.com.ua/catalog/c_img/siemens_a50.jpg');

INSERT INTO reviews (product_id, rating, text, name, email)
  VALUES (1, 1, 'bad', 'lolka', 'dog@gmail.com'), (1, 5, 'good', 'petrovich', ''), (1, 2, 'no', 'qwerty', '');

INSERT INTO regions (name)
  VALUES ('USA'), ('Russia');
INSERT INTO cities (name, region_id)
  VALUES ('NY', 1), ('Moscow', 2), ('Taganrog', 2);

INSERT INTO admins (login, password)
  VALUES ('admin', 'f61ad230f22ea03a487606f1e7d3967d'); #admin@admin

