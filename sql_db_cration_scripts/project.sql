
CREATE TABLE IF NOT EXISTS `project` (
  `name` varchar(255) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `expert_estimation` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `project`
  ADD PRIMARY KEY (`name`);
COMMIT;
