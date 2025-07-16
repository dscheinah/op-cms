CREATE TABLE `images`
(
    `id` INT UNSIGNED AUTO_INCREMENT,
    `file` VARCHAR(512) NOT NULL,
    `name` VARCHAR(512),
    `src` VARCHAR(512),
    `alt` VARCHAR(512),
    `title` VARCHAR(512),

    UNIQUE (`file`),

    PRIMARY KEY (`id`)
);

CREATE TABLE `galleries`
(
    `id` INT UNSIGNED AUTO_INCREMENT,
    `name` VARCHAR(512),

    PRIMARY KEY (`id`)
);

CREATE TABLE `galleries_x_images`
(
    `gallery_id` INT UNSIGNED NOT NULL,
    `image_id` INT UNSIGNED NOT NULL,
    `sort` INT,

    INDEX (`gallery_id`, `sort`),

    FOREIGN KEY (`gallery_id`)
        REFERENCES `galleries` (`id`)
        ON DELETE CASCADE,
    FOREIGN KEY (`image_id`)
        REFERENCES `images` (`id`)
        ON DELETE CASCADE,

    PRIMARY KEY (`gallery_id`, `image_id`)
);
