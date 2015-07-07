CREATE TABLE IF NOT EXISTS `beerentry` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `beerName` text CHARACTER SET utf8 NOT NULL,
  `beerLink` text CHARACTER SET utf8 NOT NULL,
  `date` date NOT NULL,
  `location` text CHARACTER SET utf8 NOT NULL,
  `companions` text CHARACTER SET utf8 NOT NULL,
  `rating` decimal(10,0) NOT NULL,
  `photosUrls` text CHARACTER SET utf8 NOT NULL,
  `notes` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;