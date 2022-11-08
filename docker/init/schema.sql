CREATE DATABASE IF NOT EXISTS `fizzbuzz` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
USE `fizzbuzz`;

CREATE TABLE IF NOT EXISTS `requests` (
    `route` varchar(255) COLLATE utf8mb4_bin NOT NULL,
    `method` varchar(10) COLLATE utf8mb4_bin NOT NULL,
    `queries` varchar(255) COLLATE utf8mb4_bin NOT NULL,
    `score` int NOT NULL DEFAULT '1',
    PRIMARY KEY (`route`,`method`,`queries`) USING BTREE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE DATABASE IF NOT EXISTS `fizzbuzz_test` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
USE `fizzbuzz_test`;

CREATE TABLE IF NOT EXISTS `requests` (
    `route` varchar(255) COLLATE utf8mb4_bin NOT NULL,
    `method` varchar(10) COLLATE utf8mb4_bin NOT NULL,
    `queries` varchar(255) COLLATE utf8mb4_bin NOT NULL,
    `score` int NOT NULL DEFAULT '1',
    PRIMARY KEY (`route`,`method`,`queries`) USING BTREE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
