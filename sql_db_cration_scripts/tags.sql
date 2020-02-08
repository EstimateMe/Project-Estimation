CREATE TABLE `tags` (
  `tag` varchar(200) NOT NULL,
  `hours` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag`);
  
INSERT INTO `tags`(`tag`, `hours`) VALUES ('html',3),('sql',3),('form',2),('button',1),('table',1);