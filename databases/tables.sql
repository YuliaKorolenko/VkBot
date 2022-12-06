CREATE TABLE IF NOT EXISTS `MyGroup` (
    `id` varchar(8) NOT NULL,
    `name` varchar(256) NOT NULL,
    `reg_open` int(1) ZEROFILL,
    `price` int(1) ZEROFILL,
    `created` datetime NOT NULL,
    PRIMARY KEY (`id`)
    )ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `MyGroup` (`id`, `name`, `reg_open`, `price`, `created`) VALUES ('aaaaaaaa', 'MyFirstSanta', 1, 0, '2012-06-01 02:12:30');


CREATE TABLE IF NOT EXISTS `Users` (
    `id` INT NOT NULL,
    `group_id` varchar(8) NOT NULL,
    `is_creator` int(1) ZEROFILL,
    `vish_list` varchar(256) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`group_id`) REFERENCES `MyGroup`(`id`) ON DELETE CASCADE
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;