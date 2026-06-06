-- Création de la base de données
CREATE DATABASE IF NOT EXISTS student_course_manager
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE student_course_manager;

-- Table students
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_complet VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    niveau VARCHAR(50) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table courses
CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(150) NOT NULL,
    enseignant VARCHAR(100) NOT NULL,
    niveau VARCHAR(50) NOT NULL,
    volume_horaire INT NOT NULL,
    statut ENUM('actif', 'inactif') DEFAULT 'actif',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table registrations
CREATE TABLE IF NOT EXISTS registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    UNIQUE KEY unique_inscription (student_id, course_id)
);

--allons avec les donnes de test

INSERT INTO students (nom_complet, email, mot_de_passe, niveau) VALUES
('Amadou Ouédraogo', 'amadou@email.com', '$2y$10$examplehashedpassword1', 'L2'),
('Fatima Traoré', 'fatima@email.com', '$2y$10$examplehashedpassword2', 'L1'),
('Issouf Kaboré', 'issouf@email.com', '$2y$10$examplehashedpassword3', 'L3');

-- 4 cours de test
INSERT INTO courses (titre, enseignant, niveau, volume_horaire, statut) VALUES
('Développement Web PHP', 'Prof. Sawadogo', 'L2', 45, 'actif'),
('Base de données MySQL', 'Prof. Compaoré', 'L2', 30, 'actif'),
('Algorithmique avancée', 'Prof. Kindo', 'L3', 60, 'actif'),
('Introduction à Linux', 'Prof. Zongo', 'L1', 20, 'inactif');

-- 2 inscriptions de test
INSERT INTO registrations (student_id, course_id) VALUES
(1, 1),
(1, 2);