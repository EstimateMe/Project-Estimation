-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2020 at 10:46 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `task` (
  `title` varchar(200) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `project_name` varchar(255) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('in_progress','finished') NOT NULL,
  `finish_date` timestamp NULL DEFAULT NULL,
  `expert_estimation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `task`
  ADD PRIMARY KEY (`title`,`project_name`);
COMMIT;

