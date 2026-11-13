DROP DATABASE IF EXISTS gaming_center_app;
CREATE DATABASE IF NOT EXISTS gaming_center_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE gaming_center_app;

CREATE TABLE gamemasters (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(30) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  nom VARCHAR(50) NOT NULL,
  cognom VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE sales (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(30) NOT NULL UNIQUE,
  tipus ENUM('PC Standard','Simuladors/Consoles','VIP') NOT NULL
) ENGINE=InnoDB;

CREATE TABLE moduls (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sala_id INT NOT NULL,
  nom VARCHAR(40) NOT NULL,
  tipus VARCHAR(40) NOT NULL,
  capacitat TINYINT UNSIGNED NOT NULL CHECK (capacitat > 0),
  FOREIGN KEY (sala_id) REFERENCES sales(id)
) ENGINE=InnoDB;

CREATE TABLE ocupacions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  modul_id INT NOT NULL,
  gamemaster_id INT NOT NULL,
  num_jugadors TINYINT UNSIGNED NOT NULL,
  data_inici DATETIME NOT NULL,
  data_fi DATETIME NULL,
  FOREIGN KEY (modul_id) REFERENCES moduls(id),
  FOREIGN KEY (gamemaster_id) REFERENCES gamemasters(id),
  INDEX idx_modul_fi (modul_id, data_fi),
  INDEX idx_inici (data_inici)
) ENGINE=InnoDB;

INSERT INTO gamemasters (id, username, password, nom, cognom) VALUES
  (1, 'nil', '$2y$12$tsq1rDrg3D7SUw9vsgcoAe9SjR42KqAnI44XXNDPHzLoeHDrTBn6m', 'Nil', ''),
  (2, 'ivan', '$2y$12$tsq1rDrg3D7SUw9vsgcoAe9SjR42KqAnI44XXNDPHzLoeHDrTBn6m', 'Ivan', ''),
  (3, 'javier', '$2y$12$tsq1rDrg3D7SUw9vsgcoAe9SjR42KqAnI44XXNDPHzLoeHDrTBn6m', 'Javier', ''),
  (4, 'carlos', '$2y$12$tsq1rDrg3D7SUw9vsgcoAe9SjR42KqAnI44XXNDPHzLoeHDrTBn6m', 'Carlos', ''),
  (5, 'esteban', '$2y$12$tsq1rDrg3D7SUw9vsgcoAe9SjR42KqAnI44XXNDPHzLoeHDrTBn6m', 'Esteban', '');

INSERT INTO sales (id, nom, tipus) VALUES
  (1, 'Sala Pikachu', 'PC Standard'),
  (2, 'Sala Bulbasaur', 'PC Standard'),
  (3, 'Sala Charmander', 'PC Standard'),
  (4, 'Sala Squirtle', 'PC Standard'),
  (5, 'Sala Gengar', 'Simuladors/Consoles'),
  (6, 'Sala Eevee', 'Simuladors/Consoles'),
  (7, 'Sala Snorlax', 'Simuladors/Consoles'),
  (8, 'Sala Mewtwo', 'VIP'),
  (9, 'Sala Rayquaza', 'VIP');

INSERT INTO moduls (id, sala_id, nom, tipus, capacitat) VALUES
  (1, 1, 'PC-01 a PC-05', 'Squad / eSports', 5),
  (2, 1, 'PC-06 a PC-07', 'Duo', 2),
  (3, 1, 'PC-08 a PC-09', 'Duo', 2),
  (4, 2, 'PC-10 a PC-14', 'Squad / eSports', 5),
  (5, 2, 'PC-15 a PC-16', 'Duo', 2),
  (6, 2, 'PC-17 a PC-18', 'Duo', 2),
  (7, 3, 'PC-19 a PC-23', 'Squad / eSports', 5),
  (8, 3, 'PC-24 a PC-25', 'Duo', 2),
  (9, 3, 'PC-26 a PC-27', 'Duo', 2),
  (10, 3, 'PC-28', 'Solo', 1),
  (11, 3, 'PC-29', 'Solo', 1),
  (12, 4, 'PC-30 a PC-34', 'Squad / eSports', 5),
  (13, 4, 'PC-35 a PC-36', 'Duo', 2),
  (14, 4, 'PC-37 a PC-38', 'Duo', 2),
  (15, 4, 'PC-39', 'Solo', 1),
  (16, 4, 'PC-40', 'Solo', 1),
  (17, 5, 'MND-01 a MND-04', 'Party / Consola', 4),
  (18, 5, 'SIM-01 a SIM-02', 'Duo', 2),
  (19, 5, 'SIM-03 a SIM-04', 'Duo', 2),
  (20, 5, 'SIM-05', 'Solo', 1),
  (21, 5, 'SIM-06', 'Solo', 1),
  (22, 6, 'MND-05 a MND-08', 'Party / Consola', 4),
  (23, 6, 'VR-01 a VR-02', 'Duo VR', 2),
  (24, 6, 'VR-03 a VR-04', 'Duo VR', 2),
  (25, 6, 'VR-05', 'Solo VR', 1),
  (26, 6, 'VR-06', 'Solo VR', 1),
  (27, 7, 'MND-09 a MND-12', 'Party / Consola', 4),
  (28, 7, 'SIM-07 a SIM-08', 'Duo', 2),
  (29, 7, 'SIM-09 a SIM-10', 'Duo', 2),
  (30, 7, 'SIM-11', 'Solo', 1),
  (31, 7, 'SIM-12', 'Solo', 1),
  (32, 8, 'VIP-01 a VIP-05', 'Squad / eSports VIP', 5),
  (33, 8, 'VIP-06 a VIP-07', 'Duo VIP', 2),
  (34, 8, 'VIP-08 a VIP-09', 'Duo VIP', 2),
  (35, 9, 'VIP-10 a VIP-14', 'Squad / eSports VIP', 5),
  (36, 9, 'VIP-15 a VIP-16', 'Duo VIP', 2),
  (37, 9, 'VIP-17 a VIP-18', 'Duo VIP', 2);

-- Historial variado de ocupaciones finalizadas para probar filtros y consultas.
INSERT INTO ocupacions (modul_id, gamemaster_id, num_jugadors, data_inici, data_fi) VALUES
  (1, 1, 5, DATE_SUB(NOW(), INTERVAL 9 DAY), DATE_SUB(NOW(), INTERVAL 9 DAY) + INTERVAL 2 HOUR),
  (2, 2, 2, DATE_SUB(NOW(), INTERVAL 8 DAY), DATE_SUB(NOW(), INTERVAL 8 DAY) + INTERVAL 90 MINUTE),
  (3, 3, 2, DATE_SUB(NOW(), INTERVAL 8 DAY), DATE_SUB(NOW(), INTERVAL 8 DAY) + INTERVAL 3 HOUR),
  (4, 1, 4, DATE_SUB(NOW(), INTERVAL 7 DAY), DATE_SUB(NOW(), INTERVAL 7 DAY) + INTERVAL 2 HOUR),
  (5, 2, 2, DATE_SUB(NOW(), INTERVAL 7 DAY), DATE_SUB(NOW(), INTERVAL 7 DAY) + INTERVAL 75 MINUTE),
  (7, 3, 5, DATE_SUB(NOW(), INTERVAL 6 DAY), DATE_SUB(NOW(), INTERVAL 6 DAY) + INTERVAL 2 HOUR),
  (8, 1, 2, DATE_SUB(NOW(), INTERVAL 6 DAY), DATE_SUB(NOW(), INTERVAL 6 DAY) + INTERVAL 60 MINUTE),
  (10, 2, 1, DATE_SUB(NOW(), INTERVAL 5 DAY), DATE_SUB(NOW(), INTERVAL 5 DAY) + INTERVAL 45 MINUTE),
  (12, 3, 5, DATE_SUB(NOW(), INTERVAL 5 DAY), DATE_SUB(NOW(), INTERVAL 5 DAY) + INTERVAL 3 HOUR),
  (13, 1, 2, DATE_SUB(NOW(), INTERVAL 4 DAY), DATE_SUB(NOW(), INTERVAL 4 DAY) + INTERVAL 90 MINUTE),
  (15, 2, 1, DATE_SUB(NOW(), INTERVAL 4 DAY), DATE_SUB(NOW(), INTERVAL 4 DAY) + INTERVAL 30 MINUTE),
  (17, 3, 4, DATE_SUB(NOW(), INTERVAL 3 DAY), DATE_SUB(NOW(), INTERVAL 3 DAY) + INTERVAL 2 HOUR),
  (18, 1, 2, DATE_SUB(NOW(), INTERVAL 3 DAY), DATE_SUB(NOW(), INTERVAL 3 DAY) + INTERVAL 90 MINUTE),
  (20, 2, 1, DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_SUB(NOW(), INTERVAL 2 DAY) + INTERVAL 45 MINUTE),
  (22, 3, 4, DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_SUB(NOW(), INTERVAL 2 DAY) + INTERVAL 3 HOUR),
  (23, 1, 2, DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_SUB(NOW(), INTERVAL 2 DAY) + INTERVAL 2 HOUR),
  (25, 2, 1, DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_SUB(NOW(), INTERVAL 1 DAY) + INTERVAL 30 MINUTE),
  (27, 3, 4, DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_SUB(NOW(), INTERVAL 1 DAY) + INTERVAL 2 HOUR),
  (28, 1, 2, DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_SUB(NOW(), INTERVAL 1 DAY) + INTERVAL 90 MINUTE),
  (30, 2, 1, DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_SUB(NOW(), INTERVAL 1 DAY) + INTERVAL 45 MINUTE),
  (32, 3, 5, DATE_SUB(NOW(), INTERVAL 12 HOUR), DATE_SUB(NOW(), INTERVAL 12 HOUR) + INTERVAL 3 HOUR),
  (33, 1, 2, DATE_SUB(NOW(), INTERVAL 10 HOUR), DATE_SUB(NOW(), INTERVAL 10 HOUR) + INTERVAL 90 MINUTE),
  (35, 2, 5, DATE_SUB(NOW(), INTERVAL 8 HOUR), DATE_SUB(NOW(), INTERVAL 8 HOUR) + INTERVAL 2 HOUR),
  (36, 3, 2, DATE_SUB(NOW(), INTERVAL 6 HOUR), DATE_SUB(NOW(), INTERVAL 6 HOUR) + INTERVAL 60 MINUTE),
  (37, 1, 2, DATE_SUB(NOW(), INTERVAL 4 HOUR), DATE_SUB(NOW(), INTERVAL 4 HOUR) + INTERVAL 2 HOUR),
  (6, 2, 2, DATE_SUB(NOW(), INTERVAL 3 HOUR), DATE_SUB(NOW(), INTERVAL 3 HOUR) + INTERVAL 80 MINUTE),
  (9, 3, 2, DATE_SUB(NOW(), INTERVAL 2 HOUR), DATE_SUB(NOW(), INTERVAL 2 HOUR) + INTERVAL 70 MINUTE),
  (14, 1, 2, DATE_SUB(NOW(), INTERVAL 80 MINUTE), DATE_SUB(NOW(), INTERVAL 80 MINUTE) + INTERVAL 50 MINUTE),
  (19, 2, 2, DATE_SUB(NOW(), INTERVAL 60 MINUTE), DATE_SUB(NOW(), INTERVAL 60 MINUTE) + INTERVAL 40 MINUTE);

-- Recursos que siguen ocupados al iniciar las pruebas.
INSERT INTO ocupacions (modul_id, gamemaster_id, num_jugadors, data_inici, data_fi) VALUES
  (1, 1, 4, DATE_SUB(NOW(), INTERVAL 25 MINUTE), NULL),
  (17, 2, 4, DATE_SUB(NOW(), INTERVAL 20 MINUTE), NULL),
  (23, 3, 2, DATE_SUB(NOW(), INTERVAL 15 MINUTE), NULL),
  (32, 2, 5, DATE_SUB(NOW(), INTERVAL 10 MINUTE), NULL),
  (20, 1, 1, DATE_SUB(NOW(), INTERVAL 5 MINUTE), NULL),
  (2, 1, 2, DATE_SUB(NOW(), INTERVAL 22 MINUTE), NULL),
  (4, 2, 5, DATE_SUB(NOW(), INTERVAL 19 MINUTE), NULL),
  (7, 3, 5, DATE_SUB(NOW(), INTERVAL 17 MINUTE), NULL),
  (12, 4, 5, DATE_SUB(NOW(), INTERVAL 14 MINUTE), NULL),
  (18, 5, 2, DATE_SUB(NOW(), INTERVAL 12 MINUTE), NULL),
  (22, 1, 4, DATE_SUB(NOW(), INTERVAL 9 MINUTE), NULL),
  (28, 2, 2, DATE_SUB(NOW(), INTERVAL 7 MINUTE), NULL),
  (33, 3, 2, DATE_SUB(NOW(), INTERVAL 4 MINUTE), NULL),
  (35, 4, 5, DATE_SUB(NOW(), INTERVAL 2 MINUTE), NULL);
