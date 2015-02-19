CREATE USER 'mapuser'@'localhost' IDENTIFIED BY 'password';
GRANT SELECT, INSERT, UPDATE ON `MapDb`.* TO 'mapuser'@'localhost';
