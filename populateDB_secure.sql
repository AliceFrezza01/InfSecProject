-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jun 05, 2023 at 10:31 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce3`
--

-- --------------------------------------------------------

--
-- Table structure for table `chatmessage`
--

CREATE TABLE `chatmessage` (
  `id` int(11) NOT NULL,
  `text` varchar(5000) NOT NULL,
  `date` datetime NOT NULL,
  `recieverUserID` int(11) NOT NULL,
  `senderUserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `price` float NOT NULL,
  `imgLink` varchar(250) NOT NULL,
  `creatorUserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `imgLink`, `creatorUserID`) VALUES
(21, 'iPhone', 499.99, 'https://images.unsplash.com/photo-1510557880182-3d4d3cba35a5?ixlib=rb-4.0.3&amp;ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&amp;auto=format&amp;fit=crop&amp;w=1170&amp;q=80', 18),
(22, 'Camera', 240, 'https://images.unsplash.com/photo-1685521454448-0d6850f4dcb0?ixlib=rb-4.0.3&amp;ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&amp;auto=format&amp;fit=crop&amp;w=1199&amp;q=80', 18),
(23, 'Chairs', 50.5, 'https://images.unsplash.com/photo-1685374156924-5230519f4ab3?ixlib=rb-4.0.3&amp;ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&amp;auto=format&amp;fit=crop&amp;w=1325&amp;q=80', 17),
(24, 'Vespa', 6220, 'https://images.unsplash.com/photo-1616581932361-f3aa7f297944?ixlib=rb-4.0.3&amp;ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&amp;auto=format&amp;fit=crop&amp;w=1287&amp;q=80', 17),
(25, 'Yellow flower', 5.3, 'https://images.unsplash.com/photo-1470509037663-253afd7f0f51?ixlib=rb-4.0.3&amp;ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&amp;auto=format&amp;fit=crop&amp;w=1287&amp;q=80', 17);

-- --------------------------------------------------------

--
-- Table structure for table `purchasedby`
--

CREATE TABLE `purchasedby` (
  `id` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `buyDate` date NOT NULL,
  `signature` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `purchasedby`
--

INSERT INTO `purchasedby` (`id`, `productID`, `userID`, `buyDate`, `signature`) VALUES
(41, 21, 15, '2023-06-05', '5s5j6dqJgbmb0qy9wFc2Uc0Kuk/HAxGAecR42mip3WKomiDGrQvmy3keEW3WCGiG0CCi74iOb4JOssqhYCJC6v+74qtspp3TuvxIZYCllWQQDcyrEAYlzGER1lLTqoQwqZNFp/AvroqiWQMnGp8IntCZQZLYQhy0SFCp6/d4ZGUtb1ZZbSSOIge2bkT4sFIfDa3NloAfhvqOwFM3mNhT2GIEc2U5m1cVtKT5hfPRSjj6Qgk9+CHp8eER0nC/lCOuDah+CPSwEX6jSlHPwiZD8OiHJYXes84SCHrKgmVbCrp5rHb/0sVjns5v5sis0iptA+iZm9z6VzJ0vrO8G8KlTw=='),
(42, 23, 15, '2023-06-05', '5s5j6dqJgbmb0qy9wFc2Uc0Kuk/HAxGAecR42mip3WKomiDGrQvmy3keEW3WCGiG0CCi74iOb4JOssqhYCJC6v+74qtspp3TuvxIZYCllWQQDcyrEAYlzGER1lLTqoQwqZNFp/AvroqiWQMnGp8IntCZQZLYQhy0SFCp6/d4ZGUtb1ZZbSSOIge2bkT4sFIfDa3NloAfhvqOwFM3mNhT2GIEc2U5m1cVtKT5hfPRSjj6Qgk9+CHp8eER0nC/lCOuDah+CPSwEX6jSlHPwiZD8OiHJYXes84SCHrKgmVbCrp5rHb/0sVjns5v5sis0iptA+iZm9z6VzJ0vrO8G8KlTw=='),
(43, 24, 16, '2023-06-05', 'YMDZF36VXjp/a366ApM+gIwCicn4eQvUGK5EtIvUG4aqeKkyRSjcsA10uvdmhJ9uXBzyS+6HqXKssk00RTUCo+FFlw78FxbBRR4ZezjeMWNYnRHcY0IqCaCTvzUcDNdjN5kongUXYRccArS8WFYq10z+ucza3KOsQdNxK2TWN6h3qPVSIcp516YVmrS5i8wV90uE59hwpIdkuJ6BUoQcxTlmlno00hXtsCMMsN4kRs8LEyM/Ex1KLlQy1tM9BaoTiNYZ1xz2c4vlH70lPRCjB1GJS3yM7gnG3cWtb5/dPxAcQys6KGzq1WwPnsbPkl3uvDrgYWMMQG/sSO/dfK40aA=='),
(44, 21, 16, '2023-06-05', 'YMDZF36VXjp/a366ApM+gIwCicn4eQvUGK5EtIvUG4aqeKkyRSjcsA10uvdmhJ9uXBzyS+6HqXKssk00RTUCo+FFlw78FxbBRR4ZezjeMWNYnRHcY0IqCaCTvzUcDNdjN5kongUXYRccArS8WFYq10z+ucza3KOsQdNxK2TWN6h3qPVSIcp516YVmrS5i8wV90uE59hwpIdkuJ6BUoQcxTlmlno00hXtsCMMsN4kRs8LEyM/Ex1KLlQy1tM9BaoTiNYZ1xz2c4vlH70lPRCjB1GJS3yM7gnG3cWtb5/dPxAcQys6KGzq1WwPnsbPkl3uvDrgYWMMQG/sSO/dfK40aA=='),
(45, 21, 19, '2023-06-05', 'edMiHI2RDYT1BcUtlz9LdJQXmZkn6csgfGFZ1rukFNS89+TQpE61nDbtkPzUnhclr8kYTdR3g2eLcUcF2Zw1CiNbwUA/w2U3Nks6PoOSrWqM2+BF1fikpBGMO017FfHiO+FuGaQgB3JPVETrWgGAebxDhHW0wFwjW1uoFot1zlLRnSXYzOOm73wZzIYpEdYIv+xAWw92U6YTU5NAY0yC+RPc9ToK0sFYUXMHpjrMep3y4hpBCi8zHECecB7JIEv/+7eo+33SwibAkaeh8pFD1wLnn5VEdp1pPxStFacl/nHpIqy/yXT5oBaSpI+N9+/P6yeu7SdI8ZkzCGP9oimbMQ==');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `text` varchar(1000) NOT NULL,
  `replyOfReviewID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `productID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `text`, `replyOfReviewID`, `userID`, `productID`) VALUES
(21, 'A bit expensive', 0, 15, 21),
(22, 'They arrived perfectly at home', 0, 15, 23),
(23, 'As nice as in the picture', 0, 15, 25),
(24, 'That\'s true', 0, 16, 21),
(25, 'Is it new?', 0, 16, 24),
(26, 'Sure!', 0, 17, 24),
(27, 'I am happy to hear that', 0, 17, 23),
(28, 'Good quality product', 1, 19, 21),
(29, 'I bought it last month, the pictures are amazing', 0, 19, 22),
(30, 'Thanks for the good review', 1, 18, 21),
(31, 'That\'s the price of quality', 0, 18, 21),
(32, 'I am happy to hear that. Keep it going!', 0, 18, 22);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(500) NOT NULL,
  `salt` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `isVendor` tinyint(1) NOT NULL,
  `privateKey` varchar(2048) NOT NULL,
  `publicKey` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `salt`, `name`, `isVendor`, `privateKey`, `publicKey`) VALUES
(15, 'alice@gmail.com', 'c6ce64589ac98f3231cc1065668eed2256dbeb8706ceff7dc743ab3c22bd0eb2a3c36423e62aec672140613aa6e9c7f0', 7845, 'alice', 0, '-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDn1O24Eokz9O6p\n5cZii5l7df8kleyOvbIEFDq9Cx8AIgfZOxRfCRyb4LCWdG0O4Yf2QFpH07ajBAhQ\n2PVoupS1nxQC+BlV+T4UyMtqqOyWIPH5svgtx3G5DxiEAtW8ykhAssYuDkvXA1IK\njTDIvePNKe3sazhOgXq+PoZ99so5QL+w3rTV54SnDh4Ra4lArbDOv7kqRL4q9iFC\nUc2yKyWN2op3OL3NOkIFHHYEhKApmsnjMUJPjGOsa71JRIRaLgcFDeEIQEFYuhC2\nXR9Q1xTo+ZKbrvpuG8GIT0f/M+rsBEu4+WVyi9v3o1L5px+KZI5S9oWfDbsQvdMK\nrRYbu4SdAgMBAAECggEAIJ8/zDUfhWYj51hj8B4AvPS/sGBAZ12eHSDTmyJjfFtN\ni23a0fywP+cAMkuzxPJLdYVcrtrFym6Y1PeSoOgQYPY/lKNgvU5TRA11Qk7+66k7\nI43hil+USxwqsPjNJsG4JRKC/JwaY+kdtEpl4PmHgqkxx6DWzYU+xmJ5/mOp1SBY\nx3CPwVzuEJvBRbLU7z8aT/ob079sNZeIMwZm1/8SdQl/scecGNLnaxQ5XhoGygBz\nvOtC5EpKFDBy2KGcliSbpH8cuohuaAsL2Pof8JqjJD58sog/6gtdspZPTLBHNq8I\nkWl8zE5g0oCuDdQPEUnxYJ8IF9Mjq6g75lTCaOKPgQKBgQDwK4UPwLbp9y9HV75V\nbfrPJMyIAFc6grxKzoigcYQLaAa6lagKeM7y9hO8F8TA7C8R2SNFjQKjVZ62Gg+2\nrZ95UMSfD8qSshXZO30MDg/EcpX5HxQ0Nfw6dFrpISpVOPp6t54D983G0qP3s5Fc\nxP9KVwFBrb8tX9zOZ3hxCP4wbQKBgQD3HLbiYNgC2q5RcDi0g838ujSZbudaUpEQ\ngpfEpJcLYGbOn8tG42jNwSZ45ww99It7tQbUob+0uOOYgRWtwdfYWOFYzIL7Foc9\nFjgougSrmdIc0T7SXqxxbTrFt5L/fh8Z49Gv0rVHeeaGHuKaQpBUg2oAvYdO7pBO\nISkv7+bm8QKBgBj/HpE+KIt/W59cRYYUtUb7+IGrL2j6lGhgyJ2SUwDw6cpfqyaz\n3i4xaGpqOuMtcdS0udQSUhT341Xmrn3/4ho5Ss2XUikkedurMl+f0wpKNsu/7VVl\nzQO0eoXLGuHV1VQSalLVZshrwf8U5Gs4Ya22En5oe/5X/N5KrKFvIy2dAoGBALIz\nfdtglUXxp3XJJMtgpYJUUaw4IxSqqDwswP+o5dfpbBojd/cl9aUzXeggTl67ZH8Q\ne92Iy3OrRU3sANMuD9bPuapMyUQC6gHubQ9JniaVpcTsTI5ugZLGf3SnvpUKwajs\n9oEBxYLG8KvVx/oQeH7Jyf7ArrwII/6DwWz1ZyExAoGAU192hwsSaRkPprgCyTBP\nh1wFdU1lYsilYvUUT0gMp/uBrCgwxN2kQv3lFonoukwc4yqekTOL25uGdBLhP1DH\nZ5iMhdKYvQs09QMPlWfUmIAVdTOceM1wlblH6whMugjSFgNiVJjjHBMXfcI1QMwx\nzFd+DoPnUDhS0vFgubcmETg=\n-----END PRIVATE KEY-----\n', '-----BEGIN PUBLIC KEY-----\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA59TtuBKJM/TuqeXGYouZ\ne3X/JJXsjr2yBBQ6vQsfACIH2TsUXwkcm+CwlnRtDuGH9kBaR9O2owQIUNj1aLqU\ntZ8UAvgZVfk+FMjLaqjsliDx+bL4LcdxuQ8YhALVvMpIQLLGLg5L1wNSCo0wyL3j\nzSnt7Gs4ToF6vj6GffbKOUC/sN601eeEpw4eEWuJQK2wzr+5KkS+KvYhQlHNsisl\njdqKdzi9zTpCBRx2BISgKZrJ4zFCT4xjrGu9SUSEWi4HBQ3hCEBBWLoQtl0fUNcU\n6PmSm676bhvBiE9H/zPq7ARLuPllcovb96NS+acfimSOUvaFnw27EL3TCq0WG7uE\nnQIDAQAB\n-----END PUBLIC KEY-----\n'),
(16, 'manuel@gmail.com', '7fc4f8eab1238210c9a4a903ad39f3f2ecaf397bb3fb3c28f9f51ab94c3c711539dab6d9911cecb438a9b60f5b070c63', 9748, 'manuel', 0, '-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQChRlFS4AwrkodG\nT8bWBWf+OIWTFcWM7XaaGUaGyjSHrCLAifpI0eXj24C+fPmBp9LChxyEBAC0xttp\nLMET1u2olxEDKyK/iiMswDB/dZ6NNj1UHbBVzm8w8Z+V0eTR3BcZqrwFtVblr7FV\nOTrrmLkFiTwwXd3DM018v8Cwbn3FI1ScM+Zb+VipYV9CCfR+j2d76VSsTITEPjDk\n9eA1zLWDK92E+tBeCsAerXb8eHdksy1AmjDjM+jjU2jc4tpOJ7wYWJtLfnnupj4z\n120jIUc+k9X8XtDXMS/YjRQrSinvj6wqLuu39Ic2pZY7hKa72eUI0pSna/AGHBKU\nj1zE/OZLAgMBAAECggEAAlcZ4QD9TDiRG/UWZo6nhqndTlgXiMb9XJkXS+dtQba+\nvlqCNkJNerP5t0nq+PWtekMpp8TDGdx03J7YomgRBMxEY+5hT7Q6dHDJg1/6kAQE\nec8Aew5G0MgAz9S+5Ei0URwIJHEQNL8K7Liq4TZTIQBvzifeivGYo0HJEwZXbt/h\nebhms9mtH6UK3ilM400hrfiNueM8FGC8dp7o+SNNTG4LuXW3wiXWvwh49CAByIqY\nnFrBty/QuDXYWc0mgNgZRei+GH56vbvzTW7bvwRtLzrtxnca7MbmJJvc+8uypYR8\n8sHSoVP+OCAy0DHa3wCPjMftkrkMMV0zug+Pyf3AcQKBgQDNLhgwpXMk6uE1/f/H\nsonPzhGloOy3HcUyEASNK0RBe1iLZPbE5T0wfjcch+y/+LId6icV7GatGqRoh+S/\nIoIYswJO4cw8wsJr/FJK/jvm68v2egCetKlj2rFh8OyBtXaSVBlBMgFeNNqfkCwi\n0nur1EQHUlGrL5vH7mVHkEHZcwKBgQDJOE2qVtwUs2tLqtM/NYoKDrAxwIzEVToM\nMftky3fqRv4UnRH75SA7IrEKWEqY2xPcvkIYBKgcSCC3vusuSNOjZMtlHVxNzcGf\nxmq0WRKLwWMxxoFa0HmNIjJ8NmnrvFmUyk1IxDv2ouzl36hyc+KEN6iRdtp+VXPi\nZtO2kkNpyQKBgQDErH57gtxQcuTVwFdBsJ3xF3JK9WpyTJMNXdU/DE4tBnLliy4P\npj11Ekb5jkEd8uGpUx2MIkJ5g6Q8nqZhoE5cJpr7yezgAUAkCoVHZVM+EqA77s5R\nUpNcJ/EIFMxfuPWjZgGfQLOW/criUGw+JMxu9NUQv5ORJ92HU7i5VEoKiQKBgQCu\ntSoJydzQRG/WhP1hllTCIrqsl+gg13bM++CwRVFaokUdFLt2oBv5/EcHGl26lgyK\nzs6IGBL2a1Gs+CEuUKEg7vUCWBm6m/mPhjFDYUsO+NvtbdMGTJgdCCIZYw1YVnLZ\nE0VC9s6xeAiEFkslBKUZ81Fy62UN55f0bR9JF3lcsQKBgE7Wf2zJjLT/Zu3L9ArK\ncPH0bhvgtrHT5jfBUxZjZcwpQ1EG2CIkDNaTBqrnWi23Axz4y9hwsWKvRbyqAbEz\nHTrDSV7OkwEa4m19ukK7ZV8RNb7apE1K9Awri/JLVX2OztXlXXF9veaOq86XMRuc\nG+EZp550UbtYIWI81EjIVRR1\n-----END PRIVATE KEY-----\n', '-----BEGIN PUBLIC KEY-----\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAoUZRUuAMK5KHRk/G1gVn\n/jiFkxXFjO12mhlGhso0h6wiwIn6SNHl49uAvnz5gafSwocchAQAtMbbaSzBE9bt\nqJcRAysiv4ojLMAwf3WejTY9VB2wVc5vMPGfldHk0dwXGaq8BbVW5a+xVTk665i5\nBYk8MF3dwzNNfL/AsG59xSNUnDPmW/lYqWFfQgn0fo9ne+lUrEyExD4w5PXgNcy1\ngyvdhPrQXgrAHq12/Hh3ZLMtQJow4zPo41No3OLaTie8GFibS3557qY+M9dtIyFH\nPpPV/F7Q1zEv2I0UK0op74+sKi7rt/SHNqWWO4Smu9nlCNKUp2vwBhwSlI9cxPzm\nSwIDAQAB\n-----END PUBLIC KEY-----\n'),
(17, 'anna@gmail.com', '1539c1d47fd1691bc7b8c617e39ced00b9d976b140f1cf450baab35527128e8e487b8281ccc5537ecf6938c2d8ebd80e', 1267, 'anna', 1, '-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCio/PSWTHqxUdE\n6mpYz5qbPKoi26QMo5cQARcA7WF4O8UDvLS7ym9KMLKg71N+7h4plkEIfjLM6hk+\njbcOdrKyQMjHA4yVjz3Wa7wsMuHv4Z+DzIgW+ykktmso07dpDwAXIq7hrwgBqaQV\ng0WmhD9u8egH6JVCZ2ChTye5HglRPH0Wu66wkDyzTEIx55WmD+vh7LE4FKncYBgH\n3VzYZgIsH0n2SINXrAI8Vehy48Spw848HPIOtb+rTf2yR1mBrfpBaOv0T0/jpW54\nQxXOEareV5dunyB6okMOZlkUWSSBjkaq3ogfIPbtu38QVH0aVg710/fk6Nb3Lkau\n2c+f8PG7AgMBAAECggEAPRFBiiBKkWPMnFBGaR1eaF5xZZBB+yrrnCtEl2kKWYpb\nsckHtaFPgzRgxfPGzpibA7NyrL0x1uYpX2b3rnscIrkXij5HaZq0tc+TAqeCVT9K\n1UKVcMeSjcHe36ALNGvY9VblAkFlyLYJMbiuDNWIOeCj5mBKtvm4+yiM+kGQbwsk\npqrUq0y/YJiGLia/4iWowItDMv0Hp5mDHjb+mNh0lGUxzGD+uzzgE/NMeZrdz0bY\nRCGWIwDeCV/Ke5j1xic59tnZdI2GL7GRnbT0sHu4N3/1/smoUf1zyMGYJcQ0tFQJ\nf2rG8dPERiWsWj5M5TFroU7mDKZrvmx8Q2Sa7kCCEQKBgQC21sfslhb9G/EHjgiC\nUM8W9O2ISqeH9ac9wqhScfGloHUbLBG+n4Bo1ekfe1tkNXC4SdBp2iKnPpo9jCPI\nqAqLB+rYQ/LZ6aI4L/MyeIiECdlfWUmrSTdnU3B2uxVNKd5ouDN9nOVs9ou/ona3\nO1fLr+vLSwO/atD/DSy/iVLjqwKBgQDjuB8LAN80VM1Udu4CVxrHA6+tBr7hXOL3\n3uOlm/QAMl1rdhw/yypqR68zX4qr7dgiLQRTLxDkX83GqE0CQspDgPcfJ4a/dqb3\nuW/pGnjGVjyBqIdrLaS0BMSoF2sr2TNklpyDpN+b3DYSsBpMTuYJBxNheGrSnhAx\nwoKjz9waMQKBgQCx+TWYLKzp6bXfxbiwqNo8HWPNo+WZaVxGuOFBh1pR/3OeZHJN\nXFMROQ94LopSa9Zx/J/bOZM7uqtGt8/pNPE2ThmiM9oDlfDqwnn3Ke6woCmwL2iP\nS3CbqlOxrv/YIaY1xv+QCRYlz4NOoWTvjNs0EOTz+OwH+oC/k+J3+sLtiwKBgGqp\nbljwEpxncDm07yzHcfJv5pRsCXJz2JfznbuPfc2tyZYxH3A+EGLxqr2sbb60TD1N\nyq3P6OCfgzoe0NtTP3w45wd/sxzxTanRAPs1fAaik/rDXpK0MWZkqVx2g6tpNCpU\nZYE/88EEd4tvUxIVDqiB2PEZvydiBAHasuhZzyWxAoGAAKlFtG7HrA3KWw7NdeL7\nsAgC6a+uU+uySs5Ez6++XxQrrMFlhZP417HPnvccVYbCdMsObZntm0kcR+2nHs3E\ntcCFulSdPxGXmDEdpE9C2zQ5cd0XRC8JtmC6vdoO8WziMV7hxXTDusXAfbW4Wy+/\nlIqSwwxsq8jckBB1i4LGz/8=\n-----END PRIVATE KEY-----\n', '-----BEGIN PUBLIC KEY-----\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAoqPz0lkx6sVHROpqWM+a\nmzyqItukDKOXEAEXAO1heDvFA7y0u8pvSjCyoO9Tfu4eKZZBCH4yzOoZPo23Dnay\nskDIxwOMlY891mu8LDLh7+Gfg8yIFvspJLZrKNO3aQ8AFyKu4a8IAamkFYNFpoQ/\nbvHoB+iVQmdgoU8nuR4JUTx9FruusJA8s0xCMeeVpg/r4eyxOBSp3GAYB91c2GYC\nLB9J9kiDV6wCPFXocuPEqcPOPBzyDrW/q039skdZga36QWjr9E9P46VueEMVzhGq\n3leXbp8geqJDDmZZFFkkgY5Gqt6IHyD27bt/EFR9GlYO9dP35OjW9y5GrtnPn/Dx\nuwIDAQAB\n-----END PUBLIC KEY-----\n'),
(18, 'simone@gmail.com', 'e876f5a9eaf89e606934ba33f16a9c7842ceef00d033d1eb01ce7256ed6451d37f5121777a6b68c2fa9856b2403cbc3d', 6816, 'simone', 1, '-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCpGrRim44hwfB1\nd9JTgqlQ9ySzARyEWH4uVtvCV3A3QznBlFIMhO3HuXT5TjeeMQXNfqyj2fSKDb4h\nZS8VevGDR6VIDDLUIiqzh4kixP6CHqTqK0u7MfJJ+2mwrhQ+fL18bLj1oa+5QcAq\nDKx9REUBc2Hh/sys1qhvJsjjAJ+xZsOHZ5ONyuQL4ZjKOf/OaKJg23ZuvGatuEA0\ns7Ry9wD6MtfTtgGsHMZrDRUyllk4Fs2HuVf6bg57OfRDNtk0+cDqQ16E+t+DQLlM\nENWwXwwgUFqMEA+ZJNNsc9/nf2mpPTlYev0+fD61PNYSSDkhMZt4zSYDC/8m2Qky\nK2X70/11AgMBAAECggEAE+Q1Rcggfu4ON/MhRXuAKSr5ISlHTnYOWasT7JdWdtms\niI3G3Pwh8DVrggvmVPBVS2fULO3tavPU4p7BXBh7IkMiOQheTj+6oCWYRwO/IFU0\ndusi3GEyq+sr8oF3liYcL++mDha30eXfEdMt0wpdx57n66qKLuaNJ437YWBoaHiK\nEm7/44dYNxgn4kWdJiiWwueoxGotT73DnpxIJ0OTJwd9+t3/o9dkJCQnjoH0ZlVl\n5eAk4eMLihBp0TM2RbevUXOq20Z8bH7Z9ZBEPQlVxZ7zpWIcEymN58MJKAWqsfNJ\nMyt1Vf3PrYVscKIq0franXexbsFb/LoToE5AP37SIQKBgQDFy51XAyRlqyq19L3f\n1tb2qTKbNJGHvEDXshIFu6s1TtbMzKWc5XQ7kBX7OlmJ/fdkNIIp0ntPNoU6ifsk\nOl0mCWZhoiPfkiyeUHmt7JwOMthPLqyo10RVd+mhI1gxp+UOrumEsDLL2nNn9u/s\nXCiJfhTrYJaA9Yux+Lgf/ogR2QKBgQDa3bnjMdg25lSw3/7IvMQ3RiQRlg5BNU7I\nb4HPil/wYJZKHFndsQF5TcnZW7YnhHLjdGwOLP+NHuq5vIUUr8MxAcXU59fGBxYV\nMNk2Zjqlfw/Lui3r4QFMmQVZh6d6Kw3gIO3OLyQqyElhr2Yh7THUbzPuktMuW5te\nHnTQ1xrq/QKBgQCc8h3cxy+ARLtVOefXzz8u5b60DJhVXfkNrcxDJFCLsg0a4F+h\nCSibgo8Ok5QsvIoqxsdprAwQJLC+bHIMowr6fYbxfZh9dB1XWX/Tk+WYFpww6FY0\neutL7iRBqiv26sQETKIamT0VKDdejUB/CflYb+Tlh/SkSzIXe8WODYemsQKBgQDY\nkmMor9/1o0HWrC/fzvqSf3Ode1CrseY9bCmVhqWcpNbSiu9Z8Zc1w4Wi8Z9zxxow\nfLmX5WsS5675D9TYPXv2eHycSrY3HDf7zBSEQfByZyLoQ1jBeirg8uJaT2On/gaC\n69KlHfy54OrMINX9aErQnSFUSDF0Q+2f2p9ZMCFQuQKBgAyxOgz9eShXBRwLXWr3\nbvYc5z+Qv5hj3ii2lfaDHPxUQr4ZgSwWYjLtI3soYYIfYtbkxGW7jtSFtPfU1tNA\nxvI4HgGsMBzF5SmYIdPndhXbk/UsOVciq7adtGDIpVWeZTeji+eg9M0uiohySMqa\nvtayJmSqExgxl5RED3umWho1\n-----END PRIVATE KEY-----\n', '-----BEGIN PUBLIC KEY-----\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqRq0YpuOIcHwdXfSU4Kp\nUPckswEchFh+LlbbwldwN0M5wZRSDITtx7l0+U43njEFzX6so9n0ig2+IWUvFXrx\ng0elSAwy1CIqs4eJIsT+gh6k6itLuzHySftpsK4UPny9fGy49aGvuUHAKgysfURF\nAXNh4f7MrNaobybI4wCfsWbDh2eTjcrkC+GYyjn/zmiiYNt2brxmrbhANLO0cvcA\n+jLX07YBrBzGaw0VMpZZOBbNh7lX+m4Oezn0QzbZNPnA6kNehPrfg0C5TBDVsF8M\nIFBajBAPmSTTbHPf539pqT05WHr9Pnw+tTzWEkg5ITGbeM0mAwv/JtkJMitl+9P9\ndQIDAQAB\n-----END PUBLIC KEY-----\n'),
(19, 'michele@gmail.com', '5ac92773deee619a405576f1f52fe2a4a2ac45b5f9f88daf63b6a4c413d0a124438d99c97ec8c8e9329e46304ac62988', 1100, 'michele', 0, '-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQC3F7A58lhLlqeY\nEgK7YbsDNCWYk44cvWHtfweZ87y166Ggu3uiscs1/8crTQChP/korZCjnqsy6Xd3\nRwVi4GAlDmtakIe6lwvD+kWYDygn0znXzx0amNzWgN+9AIDkDDBsQbYvGcYg7Dxv\nzoGnUA7lLUrihm1mOyvrs87nFPwjmaFd0ghPjvJtT9LWMHl9syuPd3X8Vb1xS9fw\nOmoM2bccd5emF0D0tY/8FQ08jPc7YaHwfjU/GmX3YpZqcJdFEZrWdpejV6HtQNyp\nGTDjgd5AxIt4sswcfl12x1DyP/6nm186PF41OyfjDhb21lOPTH/zEOcwbxRoaJ2T\nS25ZgGV9AgMBAAECggEAF8uq2iUeh5hpaLCyjTLq8MQmvLk0p5SPdSPk04Pje0tI\nAtFLBL6RuA9pjb2gvtRHKBvCqBk3i9Le9XAUCaE6raY9mpQdJ8l4vHw67kPOBrsD\nkgI3eJz0WqZ+LZyyo7DX3EIAEQgLAX1ib2+J1zpm7S8hQ+aPslEvaJ9CXTMTf/a/\nPXJK2x1uIeCXjBvJju3uNyjM2Vl7X1S9bZZDHr5ltQryHAyxWC9aRknndE5RSL2S\nJv/WdEOoMXxZTuCz9dMGUllry5NH0RY7ND/DCFij6ex+mGpmjPHfSw90gEfS+gal\n1RQFLWcFhErVq5IxFfus3ci6FGz6zMWLtpj/SrBVSwKBgQC8v6cQqTbTeOn+Pqva\nqiNcnhYdFez4zAReN0pW403tT1JQvhqQWI+tXGoqxWs0qbQ8ZsfnGfIsJqGB6yxc\npI2qwm6vINLWhLPzJEsbMfrq72ZCoccNPqDDN+8Bta15K9PZj2iLqNHrtZCzRmFa\n0dEtUTJiOlPqPBsXLPJ9mjTI0wKBgQD4VB/eIp3AsMfUXESgbYmsMhrZ6PBjXFhy\n/sBqSzU+gnuEdea8wZOXC1JofiRIMfvvgb9mBXmaZTaiZgylTyPMz8RWqhHhLDoh\nPiUaTcRRB6EVOLFCEJJw4DEfWcbbFjtzlPs3x1RVbh06I9hcgUmGX+EEojf7P5pw\nK1Ob3TombwKBgD+87Hq42bXR6BqeKUR/Hc/h5o/N3qcppfP28diji6YumhqAB9Jk\nxagCRCvLXOd8w0t+XdURsvDr3rBTrThfrSNT4zKqf+hHCcl6oQ4+83+wdjTcEq7L\nTlh+I+zM4BbCERkvz1sSGEljl8iiZK/ZmKyX9c6r6bh4saFC4WQ+1cJXAoGBANWM\nUlNOZWadH1sJdaKYT/oapGicHozzjsRlOsatoj39K4b/dMsBlJAhll5xi3XiNgsD\nArsTHj2dqFwDcgB+jATG7sqwOevvgpWvwWxbT+V2sBl1xUlQwv36bYPOSmmBNuLw\nTRDsgyNsLAohZSA3tiiuLu0zKv0O9xpax+2TUzxVAoGALdDp/0GC2nIoU+YlqNIx\nKpKY6ZA4MOSpY12+ChG71Pach6WtdrCqvhLBeN4tbIUxM8VySdsVBOd7K3nCaeQf\nLQyroXMFYNik0D71Y3Ds68OmSB8qNhzVRimCpqAMt6Otarf1PlS66aJmQ3aygLC4\nEXN75j38ZNgPVYL5JW4zlnQ=\n-----END PRIVATE KEY-----\n', '-----BEGIN PUBLIC KEY-----\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAtxewOfJYS5anmBICu2G7\nAzQlmJOOHL1h7X8HmfO8teuhoLt7orHLNf/HK00AoT/5KK2Qo56rMul3d0cFYuBg\nJQ5rWpCHupcLw/pFmA8oJ9M5188dGpjc1oDfvQCA5AwwbEG2LxnGIOw8b86Bp1AO\n5S1K4oZtZjsr67PO5xT8I5mhXdIIT47ybU/S1jB5fbMrj3d1/FW9cUvX8DpqDNm3\nHHeXphdA9LWP/BUNPIz3O2Gh8H41Pxpl92KWanCXRRGa1naXo1eh7UDcqRkw44He\nQMSLeLLMHH5ddsdQ8j/+p5tfOjxeNTsn4w4W9tZTj0x/8xDnMG8UaGidk0tuWYBl\nfQIDAQAB\n-----END PUBLIC KEY-----\n');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chatmessage`
--
ALTER TABLE `chatmessage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchasedby`
--
ALTER TABLE `purchasedby`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chatmessage`
--
ALTER TABLE `chatmessage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `purchasedby`
--
ALTER TABLE `purchasedby`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
