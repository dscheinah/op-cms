CREATE TABLE `calendar`
(
    `id` INT UNSIGNED AUTO_INCREMENT,
    `date` DATE NOT NULL,
    `time` TIME,
    `place` VARCHAR(512),
    `title` VARCHAR(512) NOT NULL,
    `description` TEXT,
    `link` VARCHAR(512),

    INDEX (`date`, `time`),

    PRIMARY KEY (`id`)
);
