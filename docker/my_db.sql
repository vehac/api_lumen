-- Table structure for table `clients`

CREATE TABLE IF NOT EXISTS `clients` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'nombre del cliente',
    `lastname` VARCHAR(100) COLLATE utf8_unicode_ci DEFAULT NULL,
    `image` VARCHAR(200) COLLATE utf8_unicode_ci DEFAULT NULL,
    `gender` CHAR(1) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'F: femenino - M: masculino',
    `description` TEXT COLLATE utf8_unicode_ci COMMENT 'descripción para el cliente',
    `phone` VARCHAR(15) COLLATE utf8_unicode_ci DEFAULT NULL,
    `country` VARCHAR(50) COLLATE utf8_unicode_ci DEFAULT NULL,
    `address` VARCHAR(150) COLLATE utf8_unicode_ci DEFAULT NULL,
    `birth_date` DATE DEFAULT NULL,
    `created_at` DATETIME DEFAULT NULL,
    `updated_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='tabla de clientes';

INSERT INTO clients(`name`, `lastname`, `image`, `gender`, `description`, `phone`, `country`, `address`, `birth_date`, `created_at`) VALUES 
('Luis', 'Vargas Vargas', 'myimage_1.png', 'M', 'Esta es una descripción del cliente Luis', '948252525', 'Perú', 'Los jardines #777', '1986-12-01', NOW());