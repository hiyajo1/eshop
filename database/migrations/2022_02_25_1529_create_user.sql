CREATE TABLE `users` (
`id` int(11) NOT NULL,
`login` varchar(20)  NOT NULL,
`password` varchar(50)  NOT NULL,
`salt` varchar(10)  NOT NULL,
`status` int(2) NOT NULL
);

INSERT INTO `users` (`id`, `login`, `password`, `salt`, `status`) VALUES
(1, 'admin', 'dbf6c2cf480caf11c3c73c1d6a2d383f', 'sMtrnwpJ', 1),
(2, 'admin1', 'ad178e3c6cc200e45a9ccc88f6a99f9b', 'SJifk2Mk', 0);
