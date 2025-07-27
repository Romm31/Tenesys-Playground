-- Cleaned SQL Dump: Structure + 1 Admin User

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `category` (
  `cat_id` int NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `challenges` (
  `id` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `flag` varchar(100) NOT NULL,
  `score` int NOT NULL,
  `file` varchar(500) DEFAULT NULL,
  `cat_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `scoreboard` (
  `s_id` int NOT NULL,
  `user_id` int NOT NULL,
  `c_id` int NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(10) DEFAULT 'user',
  `remember_token` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `visitors` (
  `id` int NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Indexes
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `name` (`name`);

ALTER TABLE `challenges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`cat_id`);

ALTER TABLE `scoreboard`
  ADD PRIMARY KEY (`s_id`,`user_id`,`c_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `c_id` (`c_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

-- AUTO_INCREMENTs
ALTER TABLE `category`
  MODIFY `cat_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `challenges`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `scoreboard`
  MODIFY `s_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `visitors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

-- Foreign Key Constraints
ALTER TABLE `challenges`
  ADD CONSTRAINT `challenges_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `category` (`cat_id`) ON DELETE CASCADE;

ALTER TABLE `scoreboard`
  ADD CONSTRAINT `scoreboard_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `scoreboard_ibfk_2` FOREIGN KEY (`c_id`) REFERENCES `challenges` (`id`) ON DELETE CASCADE;

-- Insert default admin user
INSERT INTO `users` (`name`, `email`, `password`, `role`, `remember_token`) VALUES
('Admin', 'admin@admin.com', '$2y$10$KIXu8aOLHv6Rn9Y6Uq96rOFZ7qzUWXzHdYi2Dw.CMnbPXKD4tkKWW', 'admin', NULL);

COMMIT;
