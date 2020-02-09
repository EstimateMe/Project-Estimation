CREATE TABLE `task` (
  `title` varchar(200) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `project_name` varchar(255) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('to_do', 'in_progress','finished') NOT NULL,
  `finish_date` date DEFAULT NULL,
  `expert_estimation` int(11) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `actual_hours` int(11) DEFAULT NULL,
  `user` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `task`
  ADD PRIMARY KEY (`title`,`project_name`);
COMMIT;