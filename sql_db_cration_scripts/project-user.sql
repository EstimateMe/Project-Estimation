
CREATE TABLE IF NOT EXISTS `project-user` (
  `username` varchar(200) NOT NULL,
  `projectName` varchar(200) NOT NULL,
  `isOwner` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `project-user`
  ADD PRIMARY KEY (`username`,`projectName`);
COMMIT;

INSERT INTO `project-user` (`username`, `projectName`, `isOwner`) VALUES
('me', 'Mine', 0),
('root', 'myProject', 1),
('root', 'project2', 1),
('root', 'project3', 1),
('test', 'myProject', 0),
('test', 'project2', 0),
('test', 'project3', 0);

