-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 21 Ağu 2022, 17:37:33
-- Sunucu sürümü: 10.4.24-MariaDB
-- PHP Sürümü: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `blog`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `blog`
--

CREATE TABLE `blog` (
  `blogid` int(255) NOT NULL,
  `blogtitle` varchar(80) NOT NULL,
  `blogtext` mediumtext NOT NULL,
  `user` varchar(255) NOT NULL,
  `time` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `blog`
--

INSERT INTO `blog` (`blogid`, `blogtitle`, `blogtext`, `user`, `time`) VALUES
(35, 'Tested', 'Tested', 'admin', '2022-08-21 05:37:26.000000');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `registerdate` date NOT NULL,
  `authority` varchar(255) NOT NULL DEFAULT 'User'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `registerdate`, `authority`) VALUES
(8, 'admin', 'admin@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '2022-08-21', 'Admin');

-- Create the blog_likes table without foreign key constraints
CREATE TABLE `blog_likes` (
  `like_id` INT NOT NULL AUTO_INCREMENT,
  `blog_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`like_id`)
);

-- CREATE TABLE `blog_likes` (
--   `like_id` INT NOT NULL AUTO_INCREMENT,
--   `blog_id` INT NOT NULL,
--   `user_id` INT NOT NULL,
--   PRIMARY KEY (`like_id`),
--   FOREIGN KEY (`blog_id,blog_likes`) REFERENCES `blog`(`blogid`) ON DELETE CASCADE
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create the blog_dislikes table without foreign key constraints
CREATE TABLE `blog_dislikes` (
  `dislike_id` INT NOT NULL AUTO_INCREMENT,
  `blog_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`dislike_id`)
);

-- Create the blog_comments table without foreign key constraints

CREATE TABLE `blog_comments` (
  `comment_id` INT NOT NULL AUTO_INCREMENT,
  `blog_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `comment_text` TEXT NOT NULL,
  `comment_time` DATETIME(6) NOT NULL,
  PRIMARY KEY (`comment_id`),
  -- FOREIGN KEY (`blog_id`) REFERENCES `blog`(`blogid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `blog_comments`
ADD CONSTRAINT `fk_user`
FOREIGN KEY (`user_id`)
REFERENCES `users` (`id`)
ON DELETE CASCADE;

ALTER TABLE `blog_comments`
ADD CONSTRAINT `blog_user`
FOREIGN KEY (`blog_id`)
REFERENCES `blog` (`blogid`)
ON DELETE CASCADE;

ALTER TABLE `blog_likes`
ADD CONSTRAINT `blog_like`
FOREIGN KEY (`blog_id`)
REFERENCES `blog` (`blogid`)
ON DELETE CASCADE;


CREATE TABLE permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    permission VARCHAR(50) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Add foreign key constraints



--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blogid`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `blog`
--
ALTER TABLE `blog`
  MODIFY `blogid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- Add foreign key constraints
ALTER TABLE `blog_likes`
  ADD CONSTRAINT `fk_blog_likes_blog_id` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`blogid`),
  ADD CONSTRAINT `fk_blog_likes_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `blog_dislikes`
  ADD CONSTRAINT `fk_blog_dislikes_blog_id` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`blogid`),
  ADD CONSTRAINT `fk_blog_dislikes_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `blog_comments`
  ADD CONSTRAINT `fk_blog_comments_blog_id` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`blogid`),
  ADD CONSTRAINT  `fk_blog_comments_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
