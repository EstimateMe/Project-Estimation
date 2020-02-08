CREATE TABLE `tags` (
  `tag` varchar(200) NOT NULL,
  `hours` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag`);
  
INSERT INTO `tags`(`tag`, `hours`) VALUES ('html',0),('sql',0),('javascript',0),('css',0),('php',0),
('page',2),('form',2),('button',1),('hyperlink',1),('picture',1), ('database',2),('table',2),('column',2),
('validation',2),('ajax request',2),('event',1),('insert into db',1), ('connect to db',1), ('query from db',2);