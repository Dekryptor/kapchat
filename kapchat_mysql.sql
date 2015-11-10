CREATE TABLE IF NOT EXISTS `kapchat` (
  `message_id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `hash` varchar(32) NOT NULL,
  `counter` int(2) NOT NULL,
  `timestamp` int(10) NOT NULL,
  `nick` char(30) NOT NULL,
  `color` varchar(7) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;
