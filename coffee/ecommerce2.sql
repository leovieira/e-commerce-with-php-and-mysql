USE `ecommerce2`;

CREATE TABLE `carts` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_session_id` CHAR(32) NOT NULL,
  `product_type` enum('coffee','goodies') NOT NULL,
  `product_id` MEDIUMINT(8) UNSIGNED NOT NULL,
  `quantity` TINYINT(3) UNSIGNED NOT NULL,
  `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `product_type` (`product_type`,`product_id`),
  KEY `user_session_id` (`user_session_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `customers` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(80) NOT NULL,
  `first_name` VARCHAR(20) NOT NULL,
  `last_name` VARCHAR(40) NOT NULL,
  `address1` VARCHAR(80) NOT NULL,
  `address2` VARCHAR(80) DEFAULT NULL,
  `city` VARCHAR(60) NOT NULL,
  `state` char(2) NOT NULL,
  `zip` MEDIUMINT(5) UNSIGNED ZEROFILL NOT NULL,
  `phone` CHAR(10) NOT NULL,
  `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `general_coffees` (
  `id` TINYINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category` VARCHAR(40) NOT NULL,
  `description` TINYTEXT,
  `image` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `non_coffee_categories` (
  `id` TINYINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category` VARCHAR(40) NOT NULL,
  `description` TINYTEXT NOT NULL,
  `image` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `non_coffee_products` (
  `id` MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `non_coffee_category_id` TINYINT(3) UNSIGNED NOT NULL,
  `name` VARCHAR(60) NOT NULL,
  `description` TINYTEXT,
  `image` VARCHAR(45) NOT NULL,
  `price` INT(10) UNSIGNED NOT NULL,
  `stock` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `non_coffee_category_id` (`non_coffee_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `orders` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` INT(10) UNSIGNED NOT NULL,
  `total` INT(10) UNSIGNED DEFAULT NULL,
  `shipping` INT(10) UNSIGNED NOT NULL DEFAULT 0,
  `credit_card_number` MEDIUMINT(4) ZEROFILL UNSIGNED NOT NULL,
  `order_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `order_date` (`order_date`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `order_contents` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` INT(10) UNSIGNED NOT NULL,
  `product_type` enum('coffee','goodies') DEFAULT NULL,
  `product_id` MEDIUMINT(8) UNSIGNED NOT NULL,
  `quantity` TINYINT(3) UNSIGNED NOT NULL,
  `price_per` INT(10) UNSIGNED NOT NULL,
  `ship_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ship_date` (`ship_date`),
  KEY `product_type` (`product_type`,`product_id`),
  KEY (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `sales` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_type` enum('coffee','goodies') DEFAULT NULL,
  `product_id` MEDIUMINT(8) UNSIGNED NOT NULL,
  `price` INT(10) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `start_date` (`start_date`),
  KEY `product_type` (`product_type`,`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `sizes` (
  `id` TINYINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `size` VARCHAR(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `size` (`size`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `specific_coffees` (
  `id` MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `general_coffee_id` TINYINT(3) UNSIGNED NOT NULL,
  `size_id` TINYINT(3) UNSIGNED NOT NULL,
  `caf_decaf` enum('caf','decaf') DEFAULT NULL,
  `ground_whole` enum('ground','whole') DEFAULT NULL,
  `price` INT(10) UNSIGNED NOT NULL,
  `stock` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `general_coffee_id` (`general_coffee_id`),
  KEY `size` (`size_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `transactions` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` INT(10) UNSIGNED NOT NULL,
  `type` VARCHAR(18) NOT NULL,
  `amount` INT(10) UNSIGNED NOT NULL,
  `response_code` TINYINT(1) UNSIGNED NOT NULL,
  `response_reason` TINYTEXT,
  `transaction_id` BIGINT(20) UNSIGNED NOT NULL,
  `response` TEXT NOT NULL,
  `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `wish_lists` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_session_id` char(32) NOT NULL,
  `product_type` enum('coffee','goodies') DEFAULT NULL,
  `product_id` MEDIUMINT(8) UNSIGNED NOT NULL,
  `quantity` TINYINT(3) UNSIGNED NOT NULL,
  `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `product_type` (`product_type`,`product_id`),
  KEY `user_session_id` (`user_session_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
