CREATE TABLE `page`
(
    `type`  VARCHAR(128),
    `key`   VARCHAR(128),
    `value` INT UNSIGNED,
    PRIMARY KEY (`type`, `key`)
);

CREATE TABLE `texts`
(
    `id`      INT UNSIGNED AUTO_INCREMENT,
    `name`    VARCHAR(512),
    `content` TEXT,
    PRIMARY KEY (`id`)
);
