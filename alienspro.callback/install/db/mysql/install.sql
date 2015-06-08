CREATE TABLE `alienspro_callbackmsg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `theme` varchar(255) DEFAULT NULL,
  `time_t` varchar(255) DEFAULT NULL,
  `date_t` datetime DEFAULT NULL,
  `status` int(2) DEFAULT 0, 
  `user_answer` varchar(255) DEFAULT NULL,
  `date_answer` varchar(255) DEFAULT NULL,  
  PRIMARY KEY (`id`)
 
) ENGINE=InnoDB;

CREATE TABLE `alienspro_themelist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB;
