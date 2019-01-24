<?php

include 'database.php';

$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$conn->query("CREATE DATABASE IF NOT EXISTS $DB_NAME DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
$conn->query("use $DB_NAME");

try {
    // ____________ USER TABLE ________________
    $sql = "CREATE TABLE IF NOT EXISTS `user` (
        `id` int(11) NOT NULL AUTO_INCREMENT UNIQUE,
        `username` varchar(50) NOT NULL UNIQUE,
        `email` varchar(150) NOT NULL UNIQUE,
        `password` varchar(64) NOT NULL,
        `validated` tinyint(1) NOT NULL DEFAULT '0',
        `token` varchar(64) NOT NULL,
        `receive_notifications` tinyint(1) NOT NULL DEFAULT '1',
        PRIMARY KEY (id)
      )";
    $conn->exec($sql);

    // ____________ LIKES TABLE ________________
    $sql = "CREATE TABLE IF NOT EXISTS `likes` (
        `id` int(11) NOT NULL AUTO_INCREMENT UNIQUE,
        `user_id` int(11) NOT NULL,
        `photo_id` int(11) NOT NULL,
        PRIMARY KEY (id)
      )";
    $conn->exec($sql);

    // ____________ GALLERY TABLE ________________
    $sql = "CREATE TABLE IF NOT EXISTS `gallery` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `time_stamp` int(11) NOT NULL,
        `photo_data` longtext NOT NULL,
        PRIMARY KEY (id)
      )";
    $conn->exec($sql);

    // ____________ COMMENTS TABLE ________________
    $sql = "CREATE TABLE `comments` (
        `id` int(11) NOT NULL AUTO_INCREMENT UNIQUE,
        `user_id` int(11) NOT NULL,
        `photo_id` int(11) NOT NULL,
        `comment` text NOT NULL,
        `time_stamp` int(11) NOT NULL,
        PRIMARY KEY (id)
      )";
    $conn->exec($sql);
    }
catch(PDOException $e)
{
    $e->getMessage();
}
?>