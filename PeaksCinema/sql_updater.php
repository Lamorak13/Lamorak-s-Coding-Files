<?php
    $servername = "localhost";
    $username = "root";
    $password = "";

    $conn = new mysqli($servername, $username, $password);

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql = <<<SQL
        -- phpMyAdmin SQL Dump
        -- version 5.2.1
        -- https://www.phpmyadmin.net/
        --
        -- Host: 127.0.0.1
        -- Generation Time: Mar 08, 2026 at 03:09 PM
        -- Server version: 10.4.32-MariaDB
        -- PHP Version: 8.2.12

        SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
        START TRANSACTION;
        SET time_zone = "+00:00";


        /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
        /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
        /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
        /*!40101 SET NAMES utf8mb4 */;

        --
        -- Database: `peakscinemadb`
        --
        CREATE DATABASE IF NOT EXISTS `peakscinemadb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
        USE `peakscinemadb`;

        -- --------------------------------------------------------

        --
        -- Table structure for table `customer`
        --

        DROP TABLE IF EXISTS `customer`;
        CREATE TABLE `customer` (
          `Customer_ID` int(11) NOT NULL,
          `Name` varchar(100) NOT NULL,
          `Email` varchar(100) NOT NULL,
          `Password` varchar(255) NOT NULL,
          `PhoneNumber` varchar(10) NOT NULL,
          `CountryCode` varchar(4) NOT NULL,
          `PaymentMethod` tinytext NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        --
        -- Dumping data for table `customer`
        --

        -- --------------------------------------------------------

        --
        -- Table structure for table `e-receipt`
        --

        DROP TABLE IF EXISTS `e-receipt`;
        CREATE TABLE `e-receipt` (
          `Receipt_ID` int(11) NOT NULL,
          `PaymentID` int(11) NOT NULL,
          `DateIssued` date NOT NULL,
          `SentToEmail` varchar(100) NOT NULL,
          `ReceiptStatus` int(11) NOT NULL,
          `Status` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        -- --------------------------------------------------------

        --
        -- Table structure for table `mall`
        --

        DROP TABLE IF EXISTS `mall`;
        CREATE TABLE `mall` (
          `Mall_ID` int(11) NOT NULL,
          `MallName` tinytext NOT NULL,
          `Location` tinytext NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        --
        -- Dumping data for table `mall`
        --

        INSERT INTO `mall` (`Mall_ID`, `MallName`, `Location`) VALUES
        (1, 'SM Marikina', 'Marcos Highway, Calumpang, Marikina City, 1801, Marikina, Luzon Philippines');

        -- --------------------------------------------------------

        --
        -- Table structure for table `movie`
        --

        DROP TABLE IF EXISTS `movie`;
        CREATE TABLE `movie` (
          `Movie_ID` int(11) NOT NULL,
          `MovieName` text NOT NULL,
          `MovieDescription` mediumtext NOT NULL,
          `Genre` varchar(100) NOT NULL,
          `Rating` varchar(10) NOT NULL,
          `Runtime` int(11) NOT NULL,
          `MoviePoster` text NOT NULL,
          `MovieAvailability` tinytext NOT NULL,
          `Price` decimal(10,2) NOT NULL,
          `TrailerURL` varchar(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        --
        -- Dumping data for table `movie`
        --

        INSERT INTO `movie` (`Movie_ID`, `MovieName`, `MovieDescription`, `Genre`, `Rating`, `Runtime`, `MoviePoster`, `MovieAvailability`, `Price`, `TrailerURL`) VALUES
        (4, 'THE BATMAN', 'The Batman follows a young Bruce Wayne in his second year as Gotham’s vigilante detective, drawn into a tense hunt for a sadistic killer targeting the city’s elite. As the case deepens, Batman uncovers corruption tied to his family and confronts his own purpose. Dark, atmospheric, and noir-inspired, it blends mystery-driven storytelling with gritty action. Praised for Pattinson’s brooding portrayal, Zack Kravitz’s dynamic Catwoman, and striking visuals, it’s a gripping and thoughtful take worth watching despite its lengthy runtime.', 'Action/Crime', 'R-13', 176, 'PeaksCinema/MoviePosters/THE BATMAN.jpg', 'Now Showing', 350.00, 'https://www.youtube.com/watch?v=mqqft2x_Aa4'),
        (5, 'Superman', 'Superman must reconcile his alien Kryptonian heritage with his human upbringing as reporter Clark Kent. As the embodiment of truth, justice and the human way he soon finds himself in a world that views these as old-fashioned.', 'Superhero/Adventure/Action', 'PG', 129, 'PeaksCinema/MoviePosters/Superman.jpg', 'Now Showing', 350.00, 'https://www.youtube.com/watch?v=Ox8ZLF6cGM0&t=4s'),
        (9, 'THE ODYSSEY', 'The film follows Odysseus, the Greek king of Ithaca, as he embarks on a dangerous voyage back home after the Trojan War. Throughout his journey, he encounters various mythical beings, including the Cyclops Polyphemus, the Sirens, and the witch-goddess Circe. The narrative chronicles his struggles and adventures as he attempts to reunite with his wife, Penelope, portrayed by Anne Hathaway.', 'Adventure/Epic/Historical', 'R-16', 160, 'PeaksCinema/MoviePosters/THE ODYSSEY.jpg', 'Now Showing', 350.00, 'https://www.youtube.com/watch?v=Mzw2ttJD2qQ'),
        (24, 'Demon Slayer: Kimetsu no Yaiba - The Movie: Infinity Castle', 'The Infinity Castle arc is a pivotal segment in the \"Demon Slayer: Kimetsu no Yaiba\" series, representing the first half of the overarching Final Battle Arc. This arc plunges the Demon Slayer Corps into Muzan\'s terrifying lair, the Infinity Castle, where they face formidable Upper Rank demons in a desperate fight for survival and vengeance.', 'Animation/Action', 'R-13', 155, 'PeaksCinema/MoviePosters/Demon Slayer Kimetsu no Yaiba - The Movie Infinity Castle.jpg', 'Now Showing', 0.00, 'https://www.youtube.com/watch?v=x7uLutVRBfI&t=2s'),
        (26, 'Iron Lung', '\"Iron Lung\" is set in a post-apocalyptic future following an event known as \"The Quiet Rapture,\" which has caused all known stars and habitable planets to disappear. The story follows a convict who is sent to explore an ocean of blood discovered on a desolate moon using a small submarine called the \"Iron Lung.\" The film explores themes of isolation and survival in a universe devoid of hope, as the protagonist navigates the dangers of this eerie environment.', 'Horror/Sci-Fi', 'R-13', 125, 'PeaksCinema/MoviePosters/Iron Lung.jpg', 'Now Showing', 0.00, 'https://www.youtube.com/watch?v=i4sh-Dw4bzg'),
        (28, 'Crime 101', 'Set against the sun-bleached backdrop of Los Angeles, the film explores the tension between the hunter and the hunted. As Davis and Colvin collaborate on the heist, they face personal crossroads that complicate their plans. Detective Lubesnick\'s relentless pursuit raises the stakes, blurring the lines between law enforcement and criminality. The narrative delves into themes of moral ambiguity, the cost of choices, and the inevitability of fate as the characters confront the consequences of their actions.', 'Crime/Action', 'R-13', 140, 'PeaksCinema/MoviePosters/Crime 101.jpg', 'Now Showing', 0.00, 'https://www.youtube.com/watch?v=f5y-cziwmMw'),
        (29, 'Goat', 'A small goat with big dreams gets a once-in-a-lifetime shot to join the pros and play roarball, a high-intensity, co-ed, full-contact sport dominated by the fastest, fiercest animals in the world.', 'Animation', 'PG', 102, 'PeaksCinema/MoviePosters/Goat.jpg', 'Now Showing', 0.00, 'https://www.youtube.com/watch?v=ggZA2oi8S5s'),
        (30, 'Scream 7', 'A new Ghostface killer emerges in the town where Sidney Prescott has built a new life. Her darkest fears resurface when her daughter becomes the next target, forcing Sidney to confront the terror once again and protect her family from the relentless murderer.', 'Horror', 'R-16', 114, 'PeaksCinema/MoviePosters/Scream 7.jpg', 'Now Showing', 0.00, 'https://www.youtube.com/watch?v=UJrghaPJ0RY'),
        (31, 'The Bride', 'The story is set in 1930s Chicago, where Frankenstein seeks the help of Dr. Euphronius to create a companion. Together, they bring back to life a murdered woman, who becomes The Bride. Her existence sparks a romance, draws the attention of the police, and ignites radical social change.', 'Horror', 'R-16', 125, 'PeaksCinema/MoviePosters/The Bride.jpg', 'Now Showing', 0.00, 'https://www.youtube.com/watch?v=IhgcUArO3Uo'),
        (32, 'Sisa', 'The film is set in 1902, during the American occupation of the Philippines, a time marked by bloodshed and betrayal. Amidst this turmoil, one woman known as Sisa lives a double life. To the outside world, she appears to be a madwoman driven to the fringes of sanity by unimaginable loss. However, beneath the surface, she is a survivor and a spy, haunted by visions of a past she cannot fully grasp and fueled by an unquenchable thirst for revenge against the forces that destroyed her life. As the line between madness and reality blurs, Sisa must decide how far she is willing to go and whether she can trust anyone in this war‑torn land.', 'Historical Drama/Thriller', 'PG', 130, 'PeaksCinema/MoviePosters/Sisa.jpg', 'Now Showing', 0.00, 'https://www.youtube.com/watch?v=bLaoh4Qop1A');

        -- --------------------------------------------------------

        --
        -- Table structure for table `otp`
        --

        DROP TABLE IF EXISTS `otp`;
        CREATE TABLE `otp` (
          `otp-id` int(11) UNSIGNED NOT NULL,
          `customer_id` int(10) UNSIGNED NOT NULL,
          `otp_code` varchar(6) NOT NULL,
          `otp_expiry` datetime NOT NULL,
          `otp_resend_after` datetime NOT NULL,
          `created_at` datetime NOT NULL DEFAULT current_timestamp()
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        -- --------------------------------------------------------

        --
        -- Table structure for table `payment`
        --

        DROP TABLE IF EXISTS `payment`;
        CREATE TABLE `payment` (
          `Payment_ID` int(11) NOT NULL,
          `Ticket_ID` int(11) NOT NULL,
          `PaymentMethod` varchar(50) NOT NULL,
          `AmountPaid` decimal(10,2) NOT NULL,
          `PaymentDate` date NOT NULL,
          `PaymentStatus` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        -- --------------------------------------------------------

        --
        -- Table structure for table `seats`
        --

        DROP TABLE IF EXISTS `seats`;
        CREATE TABLE `seats` (
          `Seat_ID` int(11) NOT NULL,
          `SeatRow` varchar(10) NOT NULL,
          `SeatColumn` varchar(10) NOT NULL,
          `SeatType` varchar(50) NOT NULL,
          `SeatAvailability` int(1) DEFAULT NULL,
          `SeatPrice` tinytext DEFAULT NULL,
          `Theater_ID` int(11) NOT NULL,
          `TimeSlot_ID` int(11) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        --
        -- Dumping data for table `seats`
        --

        INSERT INTO `seats` (`Seat_ID`, `SeatRow`, `SeatColumn`, `SeatType`, `SeatAvailability`, `SeatPrice`, `Theater_ID`, `TimeSlot_ID`) VALUES
        (353, 'A', '10', 'Regular', 0, NULL, 13, NULL),
        (354, 'A', '9', 'Regular', 0, NULL, 13, NULL),
        (355, 'A', '0', 'Empty', 0, NULL, 13, NULL),
        (356, 'A', '0', 'Empty', 0, NULL, 13, NULL),
        (357, 'A', '8', 'Regular', 0, NULL, 13, NULL),
        (358, 'A', '7', 'Regular', 0, NULL, 13, NULL),
        (359, 'A', '6', 'Regular', 0, NULL, 13, NULL),
        (360, 'A', '5', 'Regular', 0, NULL, 13, NULL),
        (361, 'A', '4', 'Regular', 0, NULL, 13, NULL),
        (362, 'A', '3', 'Regular', 0, NULL, 13, NULL),
        (363, 'A', '0', 'Empty', 0, NULL, 13, NULL),
        (364, 'A', '0', 'Empty', 0, NULL, 13, NULL),
        (365, 'A', '2', 'Regular', 0, NULL, 13, NULL),
        (366, 'A', '1', 'Regular', 0, NULL, 13, NULL),
        (367, 'B', '10', 'Regular', 0, NULL, 13, NULL),
        (368, 'B', '9', 'Regular', 0, NULL, 13, NULL),
        (369, 'B', '0', 'Empty', 0, NULL, 13, NULL),
        (370, 'B', '0', 'Empty', 0, NULL, 13, NULL),
        (371, 'B', '8', 'Regular', 0, NULL, 13, NULL),
        (372, 'B', '7', 'Regular', 0, NULL, 13, NULL),
        (373, 'B', '6', 'Regular', 0, NULL, 13, NULL),
        (374, 'B', '5', 'Regular', 0, NULL, 13, NULL),
        (375, 'B', '4', 'Regular', 0, NULL, 13, NULL),
        (376, 'B', '3', 'Regular', 0, NULL, 13, NULL),
        (377, 'B', '0', 'Empty', 0, NULL, 13, NULL),
        (378, 'B', '0', 'Empty', 0, NULL, 13, NULL),
        (379, 'B', '2', 'Regular', 0, NULL, 13, NULL),
        (380, 'B', '1', 'Regular', 0, NULL, 13, NULL),
        (381, 'C', '10', 'Regular', 0, NULL, 13, NULL),
        (382, 'C', '9', 'Regular', 0, NULL, 13, NULL),
        (383, 'C', '0', 'Empty', 0, NULL, 13, NULL),
        (384, 'C', '0', 'Empty', 0, NULL, 13, NULL),
        (385, 'C', '8', 'Regular', 0, NULL, 13, NULL),
        (386, 'C', '7', 'Regular', 0, NULL, 13, NULL),
        (387, 'C', '6', 'Regular', 0, NULL, 13, NULL),
        (388, 'C', '5', 'Regular', 0, NULL, 13, NULL),
        (389, 'C', '4', 'Regular', 0, NULL, 13, NULL),
        (390, 'C', '3', 'Regular', 0, NULL, 13, NULL),
        (391, 'C', '0', 'Empty', 0, NULL, 13, NULL),
        (392, 'C', '0', 'Empty', 0, NULL, 13, NULL),
        (393, 'C', '2', 'Regular', 0, NULL, 13, NULL),
        (394, 'C', '1', 'Regular', 0, NULL, 13, NULL),
        (395, 'D', '10', 'Regular', 0, NULL, 13, NULL),
        (396, 'D', '9', 'Regular', 0, NULL, 13, NULL),
        (397, 'D', '0', 'Empty', 0, NULL, 13, NULL),
        (398, 'D', '0', 'Empty', 0, NULL, 13, NULL),
        (399, 'D', '8', 'Regular', 0, NULL, 13, NULL),
        (400, 'D', '7', 'Regular', 0, NULL, 13, NULL),
        (401, 'D', '6', 'Regular', 0, NULL, 13, NULL),
        (402, 'D', '5', 'Regular', 0, NULL, 13, NULL),
        (403, 'D', '4', 'Regular', 0, NULL, 13, NULL),
        (404, 'D', '3', 'Regular', 0, NULL, 13, NULL),
        (405, 'D', '0', 'Empty', 0, NULL, 13, NULL),
        (406, 'D', '0', 'Empty', 0, NULL, 13, NULL),
        (407, 'D', '2', 'Regular', 0, NULL, 13, NULL),
        (408, 'D', '1', 'Regular', 0, NULL, 13, NULL),
        (409, 'E', '10', 'Regular', 0, NULL, 13, NULL),
        (410, 'E', '9', 'Regular', 0, NULL, 13, NULL),
        (411, 'E', '0', 'Empty', 0, NULL, 13, NULL),
        (412, 'E', '0', 'Empty', 0, NULL, 13, NULL),
        (413, 'E', '8', 'Regular', 0, NULL, 13, NULL),
        (414, 'E', '7', 'Regular', 0, NULL, 13, NULL),
        (415, 'E', '6', 'Regular', 0, NULL, 13, NULL),
        (416, 'E', '5', 'Regular', 0, NULL, 13, NULL),
        (417, 'E', '4', 'Regular', 0, NULL, 13, NULL),
        (418, 'E', '3', 'Regular', 0, NULL, 13, NULL),
        (419, 'E', '0', 'Empty', 0, NULL, 13, NULL),
        (420, 'E', '0', 'Empty', 0, NULL, 13, NULL),
        (421, 'E', '2', 'Regular', 0, NULL, 13, NULL),
        (422, 'E', '1', 'Regular', 0, NULL, 13, NULL),
        (913, 'A', '10', 'Regular', 1, '350', 13, 20),
        (914, 'A', '9', 'Regular', 1, '350', 13, 20),
        (915, 'A', '0', 'Empty', 1, '350', 13, 20),
        (916, 'A', '0', 'Empty', 1, '350', 13, 20),
        (917, 'A', '8', 'Regular', 1, '350', 13, 20),
        (918, 'A', '7', 'Regular', 1, '350', 13, 20),
        (919, 'A', '6', 'Regular', 1, '350', 13, 20),
        (920, 'A', '5', 'Regular', 1, '350', 13, 20),
        (921, 'A', '4', 'Regular', 1, '350', 13, 20),
        (922, 'A', '3', 'Regular', 1, '350', 13, 20),
        (923, 'A', '0', 'Empty', 1, '350', 13, 20),
        (924, 'A', '0', 'Empty', 1, '350', 13, 20),
        (925, 'A', '2', 'Regular', 1, '350', 13, 20),
        (926, 'A', '1', 'Regular', 1, '350', 13, 20),
        (927, 'B', '10', 'Regular', 1, '350', 13, 20),
        (928, 'B', '9', 'Regular', 1, '350', 13, 20),
        (929, 'B', '0', 'Empty', 1, '350', 13, 20),
        (930, 'B', '0', 'Empty', 1, '350', 13, 20),
        (931, 'B', '8', 'Regular', 1, '350', 13, 20),
        (932, 'B', '7', 'Regular', 1, '350', 13, 20),
        (933, 'B', '6', 'Regular', 1, '350', 13, 20),
        (934, 'B', '5', 'Regular', 1, '350', 13, 20),
        (935, 'B', '4', 'Regular', 1, '350', 13, 20),
        (936, 'B', '3', 'Regular', 1, '350', 13, 20),
        (937, 'B', '0', 'Empty', 1, '350', 13, 20),
        (938, 'B', '0', 'Empty', 1, '350', 13, 20),
        (939, 'B', '2', 'Regular', 1, '350', 13, 20),
        (940, 'B', '1', 'Regular', 1, '350', 13, 20),
        (941, 'C', '10', 'Regular', 1, '350', 13, 20),
        (942, 'C', '9', 'Regular', 1, '350', 13, 20),
        (943, 'C', '0', 'Empty', 1, '350', 13, 20),
        (944, 'C', '0', 'Empty', 1, '350', 13, 20),
        (945, 'C', '8', 'Regular', 1, '350', 13, 20),
        (946, 'C', '7', 'Regular', 1, '350', 13, 20),
        (947, 'C', '6', 'Regular', 1, '350', 13, 20),
        (948, 'C', '5', 'Regular', 1, '350', 13, 20),
        (949, 'C', '4', 'Regular', 1, '350', 13, 20),
        (950, 'C', '3', 'Regular', 1, '350', 13, 20),
        (951, 'C', '0', 'Empty', 1, '350', 13, 20),
        (952, 'C', '0', 'Empty', 1, '350', 13, 20),
        (953, 'C', '2', 'Regular', 1, '350', 13, 20),
        (954, 'C', '1', 'Regular', 1, '350', 13, 20),
        (955, 'D', '10', 'Regular', 1, '350', 13, 20),
        (956, 'D', '9', 'Regular', 1, '350', 13, 20),
        (957, 'D', '0', 'Empty', 1, '350', 13, 20),
        (958, 'D', '0', 'Empty', 1, '350', 13, 20),
        (959, 'D', '8', 'Regular', 1, '350', 13, 20),
        (960, 'D', '7', 'Regular', 1, '350', 13, 20),
        (961, 'D', '6', 'Regular', 1, '350', 13, 20),
        (962, 'D', '5', 'Regular', 1, '350', 13, 20),
        (963, 'D', '4', 'Regular', 1, '350', 13, 20),
        (964, 'D', '3', 'Regular', 1, '350', 13, 20),
        (965, 'D', '0', 'Empty', 1, '350', 13, 20),
        (966, 'D', '0', 'Empty', 1, '350', 13, 20),
        (967, 'D', '2', 'Regular', 1, '350', 13, 20),
        (968, 'D', '1', 'Regular', 1, '350', 13, 20),
        (969, 'E', '10', 'Regular', 1, '350', 13, 20),
        (970, 'E', '9', 'Regular', 1, '350', 13, 20),
        (971, 'E', '0', 'Empty', 1, '350', 13, 20),
        (972, 'E', '0', 'Empty', 1, '350', 13, 20),
        (973, 'E', '8', 'Regular', 1, '350', 13, 20),
        (974, 'E', '7', 'Regular', 1, '350', 13, 20),
        (975, 'E', '6', 'Regular', 1, '350', 13, 20),
        (976, 'E', '5', 'Regular', 1, '350', 13, 20),
        (977, 'E', '4', 'Regular', 1, '350', 13, 20),
        (978, 'E', '3', 'Regular', 1, '350', 13, 20),
        (979, 'E', '0', 'Empty', 1, '350', 13, 20),
        (980, 'E', '0', 'Empty', 1, '350', 13, 20),
        (981, 'E', '2', 'Regular', 1, '350', 13, 20),
        (982, 'E', '1', 'Regular', 1, '350', 13, 20),
        (983, 'A', '10', 'Regular', 1, '330', 13, 21),
        (984, 'A', '9', 'Regular', 1, '330', 13, 21),
        (985, 'A', '0', 'Empty', 1, '330', 13, 21),
        (986, 'A', '0', 'Empty', 1, '330', 13, 21),
        (987, 'A', '8', 'Regular', 1, '330', 13, 21),
        (988, 'A', '7', 'Regular', 1, '330', 13, 21),
        (989, 'A', '6', 'Regular', 1, '330', 13, 21),
        (990, 'A', '5', 'Regular', 1, '330', 13, 21),
        (991, 'A', '4', 'Regular', 1, '330', 13, 21),
        (992, 'A', '3', 'Regular', 1, '330', 13, 21),
        (993, 'A', '0', 'Empty', 1, '330', 13, 21),
        (994, 'A', '0', 'Empty', 1, '330', 13, 21),
        (995, 'A', '2', 'Regular', 1, '330', 13, 21),
        (996, 'A', '1', 'Regular', 1, '330', 13, 21),
        (997, 'B', '10', 'Regular', 1, '330', 13, 21),
        (998, 'B', '9', 'Regular', 1, '330', 13, 21),
        (999, 'B', '0', 'Empty', 1, '330', 13, 21),
        (1000, 'B', '0', 'Empty', 1, '330', 13, 21),
        (1001, 'B', '8', 'Regular', 1, '330', 13, 21),
        (1002, 'B', '7', 'Regular', 1, '330', 13, 21),
        (1003, 'B', '6', 'Regular', 1, '330', 13, 21),
        (1004, 'B', '5', 'Regular', 1, '330', 13, 21),
        (1005, 'B', '4', 'Regular', 1, '330', 13, 21),
        (1006, 'B', '3', 'Regular', 1, '330', 13, 21),
        (1007, 'B', '0', 'Empty', 1, '330', 13, 21),
        (1008, 'B', '0', 'Empty', 1, '330', 13, 21),
        (1009, 'B', '2', 'Regular', 1, '330', 13, 21),
        (1010, 'B', '1', 'Regular', 1, '330', 13, 21),
        (1011, 'C', '10', 'Regular', 1, '330', 13, 21),
        (1012, 'C', '9', 'Regular', 1, '330', 13, 21),
        (1013, 'C', '0', 'Empty', 1, '330', 13, 21),
        (1014, 'C', '0', 'Empty', 1, '330', 13, 21),
        (1015, 'C', '8', 'Regular', 1, '330', 13, 21),
        (1016, 'C', '7', 'Regular', 1, '330', 13, 21),
        (1017, 'C', '6', 'Regular', 1, '330', 13, 21),
        (1018, 'C', '5', 'Regular', 1, '330', 13, 21),
        (1019, 'C', '4', 'Regular', 1, '330', 13, 21),
        (1020, 'C', '3', 'Regular', 1, '330', 13, 21),
        (1021, 'C', '0', 'Empty', 1, '330', 13, 21),
        (1022, 'C', '0', 'Empty', 1, '330', 13, 21),
        (1023, 'C', '2', 'Regular', 1, '330', 13, 21),
        (1024, 'C', '1', 'Regular', 1, '330', 13, 21),
        (1025, 'D', '10', 'Regular', 1, '330', 13, 21),
        (1026, 'D', '9', 'Regular', 1, '330', 13, 21),
        (1027, 'D', '0', 'Empty', 1, '330', 13, 21),
        (1028, 'D', '0', 'Empty', 1, '330', 13, 21),
        (1029, 'D', '8', 'Regular', 1, '330', 13, 21),
        (1030, 'D', '7', 'Regular', 1, '330', 13, 21),
        (1031, 'D', '6', 'Regular', 1, '330', 13, 21),
        (1032, 'D', '5', 'Regular', 1, '330', 13, 21),
        (1033, 'D', '4', 'Regular', 1, '330', 13, 21),
        (1034, 'D', '3', 'Regular', 1, '330', 13, 21),
        (1035, 'D', '0', 'Empty', 1, '330', 13, 21),
        (1036, 'D', '0', 'Empty', 1, '330', 13, 21),
        (1037, 'D', '2', 'Regular', 1, '330', 13, 21),
        (1038, 'D', '1', 'Regular', 1, '330', 13, 21),
        (1039, 'E', '10', 'Regular', 1, '330', 13, 21),
        (1040, 'E', '9', 'Regular', 1, '330', 13, 21),
        (1041, 'E', '0', 'Empty', 1, '330', 13, 21),
        (1042, 'E', '0', 'Empty', 1, '330', 13, 21),
        (1043, 'E', '8', 'Regular', 1, '330', 13, 21),
        (1044, 'E', '7', 'Regular', 1, '330', 13, 21),
        (1045, 'E', '6', 'Regular', 1, '330', 13, 21),
        (1046, 'E', '5', 'Regular', 1, '330', 13, 21),
        (1047, 'E', '4', 'Regular', 1, '330', 13, 21),
        (1048, 'E', '3', 'Regular', 1, '330', 13, 21),
        (1049, 'E', '0', 'Empty', 1, '330', 13, 21),
        (1050, 'E', '0', 'Empty', 1, '330', 13, 21),
        (1051, 'E', '2', 'Regular', 1, '330', 13, 21),
        (1052, 'E', '1', 'Regular', 1, '330', 13, 21),
        (1053, 'A', '10', 'Regular', 1, '330', 13, 22),
        (1054, 'A', '9', 'Regular', 1, '330', 13, 22),
        (1055, 'A', '0', 'Empty', 1, '330', 13, 22),
        (1056, 'A', '0', 'Empty', 1, '330', 13, 22),
        (1057, 'A', '8', 'Regular', 1, '330', 13, 22),
        (1058, 'A', '7', 'Regular', 1, '330', 13, 22),
        (1059, 'A', '6', 'Regular', 1, '330', 13, 22),
        (1060, 'A', '5', 'Regular', 1, '330', 13, 22),
        (1061, 'A', '4', 'Regular', 1, '330', 13, 22),
        (1062, 'A', '3', 'Regular', 1, '330', 13, 22),
        (1063, 'A', '0', 'Empty', 1, '330', 13, 22),
        (1064, 'A', '0', 'Empty', 1, '330', 13, 22),
        (1065, 'A', '2', 'Regular', 1, '330', 13, 22),
        (1066, 'A', '1', 'Regular', 1, '330', 13, 22),
        (1067, 'B', '10', 'Regular', 1, '330', 13, 22),
        (1068, 'B', '9', 'Regular', 1, '330', 13, 22),
        (1069, 'B', '0', 'Empty', 1, '330', 13, 22),
        (1070, 'B', '0', 'Empty', 1, '330', 13, 22),
        (1071, 'B', '8', 'Regular', 1, '330', 13, 22),
        (1072, 'B', '7', 'Regular', 1, '330', 13, 22),
        (1073, 'B', '6', 'Regular', 1, '330', 13, 22),
        (1074, 'B', '5', 'Regular', 1, '330', 13, 22),
        (1075, 'B', '4', 'Regular', 1, '330', 13, 22),
        (1076, 'B', '3', 'Regular', 1, '330', 13, 22),
        (1077, 'B', '0', 'Empty', 1, '330', 13, 22),
        (1078, 'B', '0', 'Empty', 1, '330', 13, 22),
        (1079, 'B', '2', 'Regular', 1, '330', 13, 22),
        (1080, 'B', '1', 'Regular', 1, '330', 13, 22),
        (1081, 'C', '10', 'Regular', 1, '330', 13, 22),
        (1082, 'C', '9', 'Regular', 1, '330', 13, 22),
        (1083, 'C', '0', 'Empty', 1, '330', 13, 22),
        (1084, 'C', '0', 'Empty', 1, '330', 13, 22),
        (1085, 'C', '8', 'Regular', 1, '330', 13, 22),
        (1086, 'C', '7', 'Regular', 1, '330', 13, 22),
        (1087, 'C', '6', 'Regular', 1, '330', 13, 22),
        (1088, 'C', '5', 'Regular', 1, '330', 13, 22),
        (1089, 'C', '4', 'Regular', 1, '330', 13, 22),
        (1090, 'C', '3', 'Regular', 1, '330', 13, 22),
        (1091, 'C', '0', 'Empty', 1, '330', 13, 22),
        (1092, 'C', '0', 'Empty', 1, '330', 13, 22),
        (1093, 'C', '2', 'Regular', 1, '330', 13, 22),
        (1094, 'C', '1', 'Regular', 1, '330', 13, 22),
        (1095, 'D', '10', 'Regular', 1, '330', 13, 22),
        (1096, 'D', '9', 'Regular', 1, '330', 13, 22),
        (1097, 'D', '0', 'Empty', 1, '330', 13, 22),
        (1098, 'D', '0', 'Empty', 1, '330', 13, 22),
        (1099, 'D', '8', 'Regular', 1, '330', 13, 22),
        (1100, 'D', '7', 'Regular', 1, '330', 13, 22),
        (1101, 'D', '6', 'Regular', 1, '330', 13, 22),
        (1102, 'D', '5', 'Regular', 1, '330', 13, 22),
        (1103, 'D', '4', 'Regular', 1, '330', 13, 22),
        (1104, 'D', '3', 'Regular', 1, '330', 13, 22),
        (1105, 'D', '0', 'Empty', 1, '330', 13, 22),
        (1106, 'D', '0', 'Empty', 1, '330', 13, 22),
        (1107, 'D', '2', 'Regular', 1, '330', 13, 22),
        (1108, 'D', '1', 'Regular', 1, '330', 13, 22),
        (1109, 'E', '10', 'Regular', 1, '330', 13, 22),
        (1110, 'E', '9', 'Regular', 1, '330', 13, 22),
        (1111, 'E', '0', 'Empty', 1, '330', 13, 22),
        (1112, 'E', '0', 'Empty', 1, '330', 13, 22),
        (1113, 'E', '8', 'Regular', 1, '330', 13, 22),
        (1114, 'E', '7', 'Regular', 1, '330', 13, 22),
        (1115, 'E', '6', 'Regular', 1, '330', 13, 22),
        (1116, 'E', '5', 'Regular', 1, '330', 13, 22),
        (1117, 'E', '4', 'Regular', 1, '330', 13, 22),
        (1118, 'E', '3', 'Regular', 1, '330', 13, 22),
        (1119, 'E', '0', 'Empty', 1, '330', 13, 22),
        (1120, 'E', '0', 'Empty', 1, '330', 13, 22),
        (1121, 'E', '2', 'Regular', 1, '330', 13, 22),
        (1122, 'E', '1', 'Regular', 1, '330', 13, 22),
        (1123, 'A', '10', 'Regular', 1, '350', 13, 23),
        (1124, 'A', '9', 'Regular', 1, '350', 13, 23),
        (1125, 'A', '0', 'Empty', 1, '350', 13, 23),
        (1126, 'A', '0', 'Empty', 1, '350', 13, 23),
        (1127, 'A', '8', 'Regular', 1, '350', 13, 23),
        (1128, 'A', '7', 'Regular', 1, '350', 13, 23),
        (1129, 'A', '6', 'Regular', 1, '350', 13, 23),
        (1130, 'A', '5', 'Regular', 1, '350', 13, 23),
        (1131, 'A', '4', 'Regular', 1, '350', 13, 23),
        (1132, 'A', '3', 'Regular', 1, '350', 13, 23),
        (1133, 'A', '0', 'Empty', 1, '350', 13, 23),
        (1134, 'A', '0', 'Empty', 1, '350', 13, 23),
        (1135, 'A', '2', 'Regular', 1, '350', 13, 23),
        (1136, 'A', '1', 'Regular', 1, '350', 13, 23),
        (1137, 'B', '10', 'Regular', 1, '350', 13, 23),
        (1138, 'B', '9', 'Regular', 1, '350', 13, 23),
        (1139, 'B', '0', 'Empty', 1, '350', 13, 23),
        (1140, 'B', '0', 'Empty', 1, '350', 13, 23),
        (1141, 'B', '8', 'Regular', 1, '350', 13, 23),
        (1142, 'B', '7', 'Regular', 1, '350', 13, 23),
        (1143, 'B', '6', 'Regular', 1, '350', 13, 23),
        (1144, 'B', '5', 'Regular', 1, '350', 13, 23),
        (1145, 'B', '4', 'Regular', 1, '350', 13, 23),
        (1146, 'B', '3', 'Regular', 1, '350', 13, 23),
        (1147, 'B', '0', 'Empty', 1, '350', 13, 23),
        (1148, 'B', '0', 'Empty', 1, '350', 13, 23),
        (1149, 'B', '2', 'Regular', 1, '350', 13, 23),
        (1150, 'B', '1', 'Regular', 1, '350', 13, 23),
        (1151, 'C', '10', 'Regular', 1, '350', 13, 23),
        (1152, 'C', '9', 'Regular', 1, '350', 13, 23),
        (1153, 'C', '0', 'Empty', 1, '350', 13, 23),
        (1154, 'C', '0', 'Empty', 1, '350', 13, 23),
        (1155, 'C', '8', 'Regular', 1, '350', 13, 23),
        (1156, 'C', '7', 'Regular', 1, '350', 13, 23),
        (1157, 'C', '6', 'Regular', 1, '350', 13, 23),
        (1158, 'C', '5', 'Regular', 1, '350', 13, 23),
        (1159, 'C', '4', 'Regular', 1, '350', 13, 23),
        (1160, 'C', '3', 'Regular', 1, '350', 13, 23),
        (1161, 'C', '0', 'Empty', 1, '350', 13, 23),
        (1162, 'C', '0', 'Empty', 1, '350', 13, 23),
        (1163, 'C', '2', 'Regular', 1, '350', 13, 23),
        (1164, 'C', '1', 'Regular', 1, '350', 13, 23),
        (1165, 'D', '10', 'Regular', 1, '350', 13, 23),
        (1166, 'D', '9', 'Regular', 1, '350', 13, 23),
        (1167, 'D', '0', 'Empty', 1, '350', 13, 23),
        (1168, 'D', '0', 'Empty', 1, '350', 13, 23),
        (1169, 'D', '8', 'Regular', 1, '350', 13, 23),
        (1170, 'D', '7', 'Regular', 1, '350', 13, 23),
        (1171, 'D', '6', 'Regular', 1, '350', 13, 23),
        (1172, 'D', '5', 'Regular', 1, '350', 13, 23),
        (1173, 'D', '4', 'Regular', 1, '350', 13, 23),
        (1174, 'D', '3', 'Regular', 1, '350', 13, 23),
        (1175, 'D', '0', 'Empty', 1, '350', 13, 23),
        (1176, 'D', '0', 'Empty', 1, '350', 13, 23),
        (1177, 'D', '2', 'Regular', 1, '350', 13, 23),
        (1178, 'D', '1', 'Regular', 1, '350', 13, 23),
        (1179, 'E', '10', 'Regular', 1, '350', 13, 23),
        (1180, 'E', '9', 'Regular', 1, '350', 13, 23),
        (1181, 'E', '0', 'Empty', 1, '350', 13, 23),
        (1182, 'E', '0', 'Empty', 1, '350', 13, 23),
        (1183, 'E', '8', 'Regular', 1, '350', 13, 23),
        (1184, 'E', '7', 'Regular', 1, '350', 13, 23),
        (1185, 'E', '6', 'Regular', 1, '350', 13, 23),
        (1186, 'E', '5', 'Regular', 1, '350', 13, 23),
        (1187, 'E', '4', 'Regular', 1, '350', 13, 23),
        (1188, 'E', '3', 'Regular', 1, '350', 13, 23),
        (1189, 'E', '0', 'Empty', 1, '350', 13, 23),
        (1190, 'E', '0', 'Empty', 1, '350', 13, 23),
        (1191, 'E', '2', 'Regular', 1, '350', 13, 23),
        (1192, 'E', '1', 'Regular', 1, '350', 13, 23),
        (1193, 'A', '10', 'Regular', 1, '350', 13, 24),
        (1194, 'A', '9', 'Regular', 1, '350', 13, 24),
        (1195, 'A', '0', 'Empty', 1, '350', 13, 24),
        (1196, 'A', '0', 'Empty', 1, '350', 13, 24),
        (1197, 'A', '8', 'Regular', 1, '350', 13, 24),
        (1198, 'A', '7', 'Regular', 1, '350', 13, 24),
        (1199, 'A', '6', 'Regular', 1, '350', 13, 24),
        (1200, 'A', '5', 'Regular', 1, '350', 13, 24),
        (1201, 'A', '4', 'Regular', 1, '350', 13, 24),
        (1202, 'A', '3', 'Regular', 1, '350', 13, 24),
        (1203, 'A', '0', 'Empty', 1, '350', 13, 24),
        (1204, 'A', '0', 'Empty', 1, '350', 13, 24),
        (1205, 'A', '2', 'Regular', 1, '350', 13, 24),
        (1206, 'A', '1', 'Regular', 1, '350', 13, 24),
        (1207, 'B', '10', 'Regular', 1, '350', 13, 24),
        (1208, 'B', '9', 'Regular', 1, '350', 13, 24),
        (1209, 'B', '0', 'Empty', 1, '350', 13, 24),
        (1210, 'B', '0', 'Empty', 1, '350', 13, 24),
        (1211, 'B', '8', 'Regular', 1, '350', 13, 24),
        (1212, 'B', '7', 'Regular', 1, '350', 13, 24),
        (1213, 'B', '6', 'Regular', 1, '350', 13, 24),
        (1214, 'B', '5', 'Regular', 1, '350', 13, 24),
        (1215, 'B', '4', 'Regular', 1, '350', 13, 24),
        (1216, 'B', '3', 'Regular', 1, '350', 13, 24),
        (1217, 'B', '0', 'Empty', 1, '350', 13, 24),
        (1218, 'B', '0', 'Empty', 1, '350', 13, 24),
        (1219, 'B', '2', 'Regular', 1, '350', 13, 24),
        (1220, 'B', '1', 'Regular', 1, '350', 13, 24),
        (1221, 'C', '10', 'Regular', 1, '350', 13, 24),
        (1222, 'C', '9', 'Regular', 1, '350', 13, 24),
        (1223, 'C', '0', 'Empty', 1, '350', 13, 24),
        (1224, 'C', '0', 'Empty', 1, '350', 13, 24),
        (1225, 'C', '8', 'Regular', 1, '350', 13, 24),
        (1226, 'C', '7', 'Regular', 1, '350', 13, 24),
        (1227, 'C', '6', 'Regular', 1, '350', 13, 24),
        (1228, 'C', '5', 'Regular', 1, '350', 13, 24),
        (1229, 'C', '4', 'Regular', 1, '350', 13, 24),
        (1230, 'C', '3', 'Regular', 1, '350', 13, 24),
        (1231, 'C', '0', 'Empty', 1, '350', 13, 24),
        (1232, 'C', '0', 'Empty', 1, '350', 13, 24),
        (1233, 'C', '2', 'Regular', 1, '350', 13, 24),
        (1234, 'C', '1', 'Regular', 1, '350', 13, 24),
        (1235, 'D', '10', 'Regular', 1, '350', 13, 24),
        (1236, 'D', '9', 'Regular', 1, '350', 13, 24),
        (1237, 'D', '0', 'Empty', 1, '350', 13, 24),
        (1238, 'D', '0', 'Empty', 1, '350', 13, 24),
        (1239, 'D', '8', 'Regular', 1, '350', 13, 24),
        (1240, 'D', '7', 'Regular', 1, '350', 13, 24),
        (1241, 'D', '6', 'Regular', 1, '350', 13, 24),
        (1242, 'D', '5', 'Regular', 1, '350', 13, 24),
        (1243, 'D', '4', 'Regular', 1, '350', 13, 24),
        (1244, 'D', '3', 'Regular', 1, '350', 13, 24),
        (1245, 'D', '0', 'Empty', 1, '350', 13, 24),
        (1246, 'D', '0', 'Empty', 1, '350', 13, 24),
        (1247, 'D', '2', 'Regular', 1, '350', 13, 24),
        (1248, 'D', '1', 'Regular', 1, '350', 13, 24),
        (1249, 'E', '10', 'Regular', 1, '350', 13, 24),
        (1250, 'E', '9', 'Regular', 1, '350', 13, 24),
        (1251, 'E', '0', 'Empty', 1, '350', 13, 24),
        (1252, 'E', '0', 'Empty', 1, '350', 13, 24),
        (1253, 'E', '8', 'Regular', 1, '350', 13, 24),
        (1254, 'E', '7', 'Regular', 1, '350', 13, 24),
        (1255, 'E', '6', 'Regular', 1, '350', 13, 24),
        (1256, 'E', '5', 'Regular', 1, '350', 13, 24),
        (1257, 'E', '4', 'Regular', 1, '350', 13, 24),
        (1258, 'E', '3', 'Regular', 1, '350', 13, 24),
        (1259, 'E', '0', 'Empty', 1, '350', 13, 24),
        (1260, 'E', '0', 'Empty', 1, '350', 13, 24),
        (1261, 'E', '2', 'Regular', 1, '350', 13, 24),
        (1262, 'E', '1', 'Regular', 1, '350', 13, 24);

        -- --------------------------------------------------------

        --
        -- Table structure for table `theater`
        --

        DROP TABLE IF EXISTS `theater`;
        CREATE TABLE `theater` (
          `Theater_ID` int(11) NOT NULL,
          `Mall_ID` int(11) NOT NULL,
          `TheaterName` varchar(100) NOT NULL,
          `TotalSeats` int(11) NOT NULL,
          `TheaterType` varchar(50) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        --
        -- Dumping data for table `theater`
        --

        INSERT INTO `theater` (`Theater_ID`, `Mall_ID`, `TheaterName`, `TotalSeats`, `TheaterType`) VALUES
        (13, 1, 'Director\'s Club 1', 50, 'Director\'s Club');

        -- --------------------------------------------------------

        --
        -- Table structure for table `ticket`
        --

        DROP TABLE IF EXISTS `ticket`;
        CREATE TABLE `ticket` (
          `Ticket_ID` int(11) NOT NULL,
          `Seat_ID` int(11) NOT NULL,
          `Customer_ID` int(11) NOT NULL,
          `Movie_ID` int(11) NOT NULL,
          `TimeSlot_ID` int(11) NOT NULL,
          `Price` decimal(10,2) NOT NULL,
          `Status` int(11) NOT NULL,
          `DateTime` datetime NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        -- --------------------------------------------------------

        --
        -- Table structure for table `timeslot`
        --

        DROP TABLE IF EXISTS `timeslot`;
        CREATE TABLE `timeslot` (
          `TimeSlot_ID` int(11) NOT NULL,
          `StartTime` tinytext NOT NULL,
          `EndTime` tinytext NOT NULL,
          `Date` tinytext NOT NULL,
          `ScreeningType` varchar(5) NOT NULL,
          `Movie_ID` int(11) NOT NULL,
          `Theater_ID` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        --
        -- Dumping data for table `timeslot`
        --

        INSERT INTO `timeslot` (`TimeSlot_ID`, `StartTime`, `EndTime`, `Date`, `ScreeningType`, `Movie_ID`, `Theater_ID`) VALUES
        (20, '22:30', '', '2026-03-08', '3D', 4, 13),
        (21, '22:30', '', '2026-03-08', '2D', 4, 13),
        (22, '22:30', '', '2026-03-08', '2D', 4, 13),
        (23, '23:00', '', '2026-03-09', '3D', 5, 13),
        (24, '23:00', '', '2026-03-09', '3D', 5, 13);

        --
        -- Indexes for dumped tables
        --

        --
        -- Indexes for table `customer`
        --
        ALTER TABLE `customer`
          ADD PRIMARY KEY (`Customer_ID`);

        --
        -- Indexes for table `e-receipt`
        --
        ALTER TABLE `e-receipt`
          ADD PRIMARY KEY (`Receipt_ID`);

        --
        -- Indexes for table `mall`
        --
        ALTER TABLE `mall`
          ADD PRIMARY KEY (`Mall_ID`),
          ADD UNIQUE KEY `MallName` (`MallName`) USING HASH;

        --
        -- Indexes for table `movie`
        --
        ALTER TABLE `movie`
          ADD PRIMARY KEY (`Movie_ID`);

        --
        -- Indexes for table `payment`
        --
        ALTER TABLE `payment`
          ADD PRIMARY KEY (`Payment_ID`);

        --
        -- Indexes for table `seats`
        --
        ALTER TABLE `seats`
          ADD PRIMARY KEY (`Seat_ID`),
          ADD KEY `Theater_ID` (`Theater_ID`),
          ADD KEY `seats_ibfk_2` (`TimeSlot_ID`);

        --
        -- Indexes for table `theater`
        --
        ALTER TABLE `theater`
          ADD PRIMARY KEY (`Theater_ID`),
          ADD KEY `Mall_ID` (`Mall_ID`);

        --
        -- Indexes for table `ticket`
        --
        ALTER TABLE `ticket`
          ADD PRIMARY KEY (`Ticket_ID`);

        --
        -- Indexes for table `timeslot`
        --
        ALTER TABLE `timeslot`
          ADD PRIMARY KEY (`TimeSlot_ID`),
          ADD KEY `Movie_ID` (`Movie_ID`),
          ADD KEY `Theater_ID` (`Theater_ID`);

        --
        -- AUTO_INCREMENT for dumped tables
        --

        --
        -- AUTO_INCREMENT for table `customer`
        --
        ALTER TABLE `customer`
          MODIFY `Customer_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

        --
        -- AUTO_INCREMENT for table `e-receipt`
        --
        ALTER TABLE `e-receipt`
          MODIFY `Receipt_ID` int(11) NOT NULL AUTO_INCREMENT;

        --
        -- AUTO_INCREMENT for table `mall`
        --
        ALTER TABLE `mall`
          MODIFY `Mall_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

        --
        -- AUTO_INCREMENT for table `movie`
        --
        ALTER TABLE `movie`
          MODIFY `Movie_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

        --
        -- AUTO_INCREMENT for table `payment`
        --
        ALTER TABLE `payment`
          MODIFY `Payment_ID` int(11) NOT NULL AUTO_INCREMENT;

        --
        -- AUTO_INCREMENT for table `seats`
        --
        ALTER TABLE `seats`
          MODIFY `Seat_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1263;

        --
        -- AUTO_INCREMENT for table `theater`
        --
        ALTER TABLE `theater`
          MODIFY `Theater_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

        --
        -- AUTO_INCREMENT for table `ticket`
        --
        ALTER TABLE `ticket`
          MODIFY `Ticket_ID` int(11) NOT NULL AUTO_INCREMENT;

        --
        -- AUTO_INCREMENT for table `timeslot`
        --
        ALTER TABLE `timeslot`
          MODIFY `TimeSlot_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

        --
        -- Constraints for dumped tables
        --

        --
        -- Constraints for table `seats`
        --
        ALTER TABLE `seats`
          ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`Theater_ID`) REFERENCES `theater` (`Theater_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
          ADD CONSTRAINT `seats_ibfk_2` FOREIGN KEY (`TimeSlot_ID`) REFERENCES `timeslot` (`TimeSlot_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

        --
        -- Constraints for table `theater`
        --
        ALTER TABLE `theater`
          ADD CONSTRAINT `theater_ibfk_1` FOREIGN KEY (`Mall_ID`) REFERENCES `mall` (`Mall_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

        --
        -- Constraints for table `timeslot`
        --
        ALTER TABLE `timeslot`
          ADD CONSTRAINT `timeslot_ibfk_1` FOREIGN KEY (`Movie_ID`) REFERENCES `movie` (`Movie_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
          ADD CONSTRAINT `timeslot_ibfk_2` FOREIGN KEY (`Theater_ID`) REFERENCES `theater` (`Theater_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
        COMMIT;

        /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
        /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
        /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;




        SQL;

        if ($conn->multi_query($sql)) {
            echo "yahooo";
        } else {
            echo "uh oh...";
        }
    }
    
?>

<!DOCTYPE html>
<html>
    <body>
        <main>
            <form id="createDatabase" name="createDatabase" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <button type="submit" name="createDatabase" value="createDatabase">Update Database</button>
            </form>

        </main>
    </body>
</html>