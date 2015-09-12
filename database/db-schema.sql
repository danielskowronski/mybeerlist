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

ALTER TABLE `beerentry`
ADD PRIMARY KEY (`id`);

ALTER TABLE `beerentry`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `wantedbeerentry` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `beerName` text CHARACTER SET utf8 NOT NULL,
  `beerLink` text CHARACTER SET utf8 NOT NULL,
  `notes` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

ALTER TABLE `wantedbeerentry`
ADD PRIMARY KEY (`id`);

ALTER TABLE `wantedbeerentry`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1 ;


ALTER TABLE `users` ADD `register_token` TEXT NOT NULL ;
ALTER TABLE `users` ADD `reset_token` TEXT NOT NULL ;

CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(11) NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `uid_a` int(11) NOT NULL,
  `uid_b` int(11) NOT NULL,
  `b_ignored` tinyint(1) NOT NULL DEFAULT '0',
  `date_sent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_confirmed` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

ALTER TABLE `friends`
ADD PRIMARY KEY (`uid_a`,`uid_b`), ADD UNIQUE KEY `uid_a` (`uid_a`,`uid_b`), ADD UNIQUE KEY `id` (`id`);