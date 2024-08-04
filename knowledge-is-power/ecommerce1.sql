USE `ecommerce1`;

CREATE TABLE `categories` (
	`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`category` VARCHAR(45) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `category_UNIQUE` (`category` ASC) 
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `pages` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`categories_id` SMALLINT UNSIGNED NOT NULL,
	`title` VARCHAR(100) NOT NULL,
	`description` TINYTEXT NOT NULL,
	`content` LONGTEXT NULL,
	`date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	INDEX `date_created` (`date_created` ASC),
	INDEX `fk_pages_categories_idx` (`categories_id` ASC),
	CONSTRAINT `fk_pages_categories`
		FOREIGN KEY (`categories_id`)
		REFERENCES `categories` (`id`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `pdfs` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(100) NOT NULL,
	`description` TINYTEXT NOT NULL,
	`tmp_name` CHAR(63) NOT NULL,
	`file_name` VARCHAR(100) NOT NULL,
	`size` MEDIUMINT UNSIGNED NOT NULL,
	`date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `tmp_name_UNIQUE` (`tmp_name` ASC),
	INDEX `date_created` (`date_created` ASC) 
) ENGINE = InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`type` ENUM('member','admin') NOT NULL DEFAULT 'member',
	`username` VARCHAR(45) NOT NULL,
	`email` VARCHAR(80) NOT NULL,
	`pass` VARCHAR(255) NOT NULL,
	`first_name` VARCHAR(45) NOT NULL,
	`last_name` VARCHAR(45) NOT NULL,
	`date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`date_expires` DATE NOT NULL,
	`date_modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `username_UNIQUE` (`username` ASC),
	UNIQUE INDEX `email_UNIQUE` (`email` ASC),
	INDEX `login` (`email` ASC, `pass` ASC)
) ENGINE = InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `orders` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`users_id` INT UNSIGNED NOT NULL,
	`transaction_id` VARCHAR(45) NOT NULL,
	`payment_status` VARCHAR(45) NOT NULL,
	`payment_amount` INT UNSIGNED NOT NULL,
	`date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	INDEX `date_created` (`date_created` ASC),
	INDEX `transaction_id` (`transaction_id` ASC),
	CONSTRAINT `fk_orders_users1`
		FOREIGN KEY (`users_id`)
		REFERENCES `users` (`id`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET=utf8;
