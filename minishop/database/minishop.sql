CREATE DATABASE IF NOT EXISTS `minishop`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `minishop`;

CREATE TABLE IF NOT EXISTS `categories` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `products` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `category_id` INT UNSIGNED NOT NULL,
    `name` VARCHAR(200) NOT NULL,
    `price` INT UNSIGNED NOT NULL,
    `description` TEXT,
    `image` VARCHAR(255) NOT NULL DEFAULT 'images/sp01.jpg',
    `stock` INT UNSIGNED NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_products_category`
        FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `users` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `fullname` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(15) NOT NULL,
    `address` VARCHAR(255) NOT NULL DEFAULT '',
    `role` ENUM('customer', 'admin') NOT NULL DEFAULT 'customer',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `orders` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT UNSIGNED NOT NULL,
    `fullname` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(15) NOT NULL,
    `address` VARCHAR(255) NOT NULL,
    `note` VARCHAR(500) NOT NULL DEFAULT '',
    `total` INT UNSIGNED NOT NULL,
    `status` ENUM('pending', 'shipping', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_orders_user`
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `order_items` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `order_id` INT UNSIGNED NOT NULL,
    `product_id` INT UNSIGNED NOT NULL,
    `product_name` VARCHAR(200) NOT NULL,
    `price` INT UNSIGNED NOT NULL,
    `quantity` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_order_items_order`
        FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
    CONSTRAINT `fk_order_items_product`
        FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories` (`id`, `name`) VALUES
    (1, 'Chuột và bàn phím'),
    (2, 'Âm thanh và hình ảnh'),
    (3, 'Lưu trữ và phụ kiện')
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

INSERT INTO `products`
    (`id`, `category_id`, `name`, `price`, `description`, `image`, `stock`)
VALUES
    (1, 1, 'Chuột không dây M1', 250000,
     'Chuột không dây kết nối 2.4GHz, thiết kế đối xứng, nút bấm êm, phù hợp cho học tập và làm việc văn phòng.',
     'images/sp01.jpg', 20),
    (2, 1, 'Bàn phím cơ K2', 790000, NULL, 'images/sp02.jpg', 10),
    (3, 2, 'Tai nghe Bluetooth T3', 450000, NULL, 'images/sp03.jpg', 15),
    (4, 2, 'USB 64GB U4', 150000, NULL, 'images/sp04.jpg', 50),
    (5, 1, 'Webcam Full HD W5', 520000, NULL, 'images/sp05.jpg', 8),
    (6, 3, 'Đế tản nhiệt laptop D6', 320000, NULL, 'images/sp06.jpg', 12)
ON DUPLICATE KEY UPDATE
    `category_id` = VALUES(`category_id`),
    `name` = VALUES(`name`),
    `price` = VALUES(`price`),
    `description` = VALUES(`description`),
    `image` = VALUES(`image`),
    `stock` = VALUES(`stock`);
