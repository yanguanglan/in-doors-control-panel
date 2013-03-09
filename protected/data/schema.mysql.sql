CREATE TABLE `User` (
    `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(128) NOT NULL,
    `password` VARCHAR(128) NOT NULL,
    `email` VARCHAR(128) NOT NULL
) engine InnoDB;

INSERT INTO `User` (`username`, `password`, `email`) VALUES ('admin', MD5('admin'), 'admin@example.com');
