CREATE TABLE IF NOT EXISTS `beerentry` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `beerName` text NOT NULL,
  `beerLink` text NOT NULL,
  `date` date NOT NULL,
  `location` text NOT NULL,
  `companions` text NOT NULL,
  `rating` decimal(10,0) NOT NULL,
  `photosUrls` text NOT NULL,
  `notes` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;