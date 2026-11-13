DROP DATABASE IF EXISTS gaming_center;
CREATE DATABASE gaming_center CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE gaming_center;

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

-- Un mòdul està ocupat si té una fila amb data_fi NULL.
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
  (1, 'gm.alba', 'qweQWE123', 'Alba', 'Ruiz'),
  (2, 'gm.marcos', 'qweQWE123', 'Marcos', 'Vidal'),
  (3, 'gm.sara', 'qweQWE123', 'Sara', 'Costa');

INSERT INTO sales (id, nom, tipus) VALUES
  (1, 'Sala 1', 'PC Standard'),
  (2, 'Sala 2', 'PC Standard'),
  (3, 'Sala 3', 'PC Standard'),
  (4, 'Sala 4', 'PC Standard'),
  (5, 'Sala 5', 'Simuladors/Consoles'),
  (6, 'Sala 6', 'Simuladors/Consoles'),
  (7, 'Sala 7', 'Simuladors/Consoles'),
  (8, 'Sala 8', 'VIP'),
  (9, 'Sala 9', 'VIP');

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

-- Dos ocupacions actives i dues de finalitzades per provar l'estat i l'historic.
INSERT INTO ocupacions (modul_id, gamemaster_id, num_jugadors, data_inici, data_fi) VALUES
  (1, 1, 4, DATE_SUB(NOW(), INTERVAL 25 MINUTE), NULL),
  (17, 2, 4, DATE_SUB(NOW(), INTERVAL 3 HOUR), DATE_SUB(NOW(), INTERVAL 2 HOUR)),
  (23, 3, 2, DATE_SUB(NOW(), INTERVAL 90 MINUTE), DATE_SUB(NOW(), INTERVAL 30 MINUTE)),
  (20, 1, 1, DATE_SUB(NOW(), INTERVAL 15 MINUTE), NULL);