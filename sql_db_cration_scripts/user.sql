
CREATE TABLE IF NOT EXISTS `user` ( 
  `username` varchar(200) NOT NULL,  
  `password` varchar(200) NOT NULL,
  `email` varchar(50) NOT NULL, 
  `account_type` enum('Manager','Developer') NOT NULL, 
  PRIMARY KEY (`username`)  
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

