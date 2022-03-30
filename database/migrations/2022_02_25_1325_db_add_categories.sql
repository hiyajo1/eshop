UPDATE `up_category` SET `ALIAS` = 'knigi' WHERE `up_category`.`ID` = 1;

INSERT INTO up_category
VALUES
(2, N'Детям и родителям', 1, 'detyam-i-roditelyam'),
(3, N'Художественная литература', 1, 'khudozhestvennaya-literatura'),
(4, N'Учебная литература', 1, 'uchebnaya-literatura'),
(5, N'Фэнтези', 3, 'fentezi'),
(6, N'Детективы', 3, 'detektivy'),
(7, N'Фантастика', 3, 'fantastika'),
(8, N'Приключения', 3, 'priklyucheniya'),
(9, N'Комиксы', 0, 'komiksy'),
(10, N'Marvel', 9, 'marvel'),
(11, N'DC', 9, 'dc');