DROP DATABASE IF EXISTS `e_commerce`;
CREATE DATABASE `e_commerce`;

USE e_commerce;

CREATE TABLE `user_role` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `role` varchar(255) NOT NULL
);

CREATE TABLE `country_code` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `country` varchar(255) NOT NULL
);

CREATE TABLE `user` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255),
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `user_role` int NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
);

CREATE TABLE `address` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `address_line_one` varchar(255) NOT NULL,
  `address_line_two` varchar(255),
  `address_line_three` varchar(255),
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `country_code` int,
  `user_id` int
);

CREATE TABLE `payment_detail` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int,
  `card_number` varchar(255) NOT NULL,
  `expiration_date` date NOT NULL,
  `cvv` varchar(255) NOT NULL
);

CREATE TABLE `purchase` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int,
  `shipping_address` int,
  `payment_method` int,
  `order_status` ENUM ('pending', 'successful', 'failed'),
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
);

CREATE TABLE `category` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  `image` varchar(255)
);

CREATE TABLE `product` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `size` varchar(255),
  `category` int,
  `images` varchar(255)
);

CREATE TABLE `product_purchase` (
  `product_id` int,
  `purchase_id` int,
  `quantity` int NOT NULL,
  `price` decimal NOT NULL,
  `tax` decimal NOT NULL,
  `shipping_cost` decimal NOT NULL,
  PRIMARY KEY (`product_id`, `purchase_id`)
);

CREATE TABLE `stock` (
  `product_id` int PRIMARY KEY,
  `quantity_available` int NOT NULL,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `rating` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `rating` int NOT NULL,
  `user_id` int,
  `product_id_id` int,
  `message` text,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
);

ALTER TABLE `user` ADD FOREIGN KEY (`user_role`) REFERENCES `user_role` (`id`);

ALTER TABLE `address` ADD FOREIGN KEY (`country_code`) REFERENCES `country_code` (`id`);

ALTER TABLE `address` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `payment_detail` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `purchase` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `purchase` ADD FOREIGN KEY (`shipping_address`) REFERENCES `address` (`id`);

ALTER TABLE `purchase` ADD FOREIGN KEY (`payment_method`) REFERENCES `payment_detail` (`id`);

ALTER TABLE `product` ADD FOREIGN KEY (`category`) REFERENCES `category` (`id`);

ALTER TABLE `product_purchase` ADD FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

ALTER TABLE `product_purchase` ADD FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`id`);

ALTER TABLE `stock` ADD FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

ALTER TABLE `rating` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `rating` ADD FOREIGN KEY (`product_id_id`) REFERENCES `product` (`id`);

