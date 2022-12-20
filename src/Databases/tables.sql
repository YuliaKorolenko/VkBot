CREATE TABLE IF NOT EXISTS `MyGroup` (
    `id` varchar(256) NOT NULL,
    `name` varchar(256) NOT NULL,
    `reg_open` INT ZEROFILL,
    `price` int(1) ZEROFILL,
    `created` datetime NOT NULL,
    PRIMARY KEY (`id`)
    )ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `MyGroup` (`id`, `name`, `reg_open`, `price`, `created`) VALUES ('aaaaaaaa', 'MyFirstSanta', 1, 0, '2012-06-01 02:12:30');

INSERT INTO
                        `MyGroup`
                    SET
                        id = 'bbbbbbbb',
                        name = 'ojpochemy',
                        reg_open = 1,
                        price = 0,
                        created = '2012-06-01 02:12:30'


CREATE TABLE IF NOT EXISTS `Users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `group_id` varchar(8) NOT NULL,
    `is_creator` INT,
    `wish_list` varchar(256) NOT NULL,
    `state_number` varchar(256) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`group_id`) REFERENCES `MyGroup`(`id`) ON DELETE CASCADE
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE `Users`;


CREATE TABLE IF NOT EXISTS `Users` (
    `id` INT NOT NULL,
    `state_number` varchar(256) NOT NULL,
    PRIMARY KEY (`id`)
    )ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `Participants` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `group_id` varchar(256) NOT NULL,
    `is_creator` INT,
    `wish_list` varchar(256) NOT NULL,
    `is_active` INT,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`group_id`) REFERENCES `MyGroup`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `Users`(`id`) ON DELETE CASCADE
    )ENGINE=InnoDB  DEFAULT CHARSET=utf8;


INSERT INTO
    `Participants`
(user_id, group_id, is_creator, wish_list, is_active)
VALUES (229231226, 'Сантамой' , 1, '', 1);