-- FILE: db.sql
CREATE DATABASE IF NOT EXISTS nexusscholar;
USE nexusscholar;

-- Users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    cgpa_current DECIMAL(3,2) DEFAULT 0.00,
    ielts_score DECIMAL(3,1) DEFAULT 0.0,
    country VARCHAR(100) DEFAULT NULL,
    status ENUM('active','inactive') DEFAULT 'active',
    target_country VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Admins
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);
INSERT INTO admins (full_name, username, password_hash) VALUES ('System Admin', 'admin', MD5('admin123'));

-- Semesters (CGPA tracker)
CREATE TABLE semesters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    semester_name VARCHAR(50) NOT NULL,
    cgpa DECIMAL(3,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- English course scores (Eligibility calculator)
CREATE TABLE english_scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    eng101 DECIMAL(5,2) DEFAULT 0.00,
    eng103 DECIMAL(5,2) DEFAULT 0.00,
    eng105 DECIMAL(5,2) DEFAULT 0.00,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Countries (Country-specific guidelines)
CREATE TABLE countries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(80) NOT NULL,
    min_cgpa DECIMAL(3,2) DEFAULT 0.00,
    min_ielts DECIMAL(3,1) DEFAULT 0.0,
    estimated_cost_min INT DEFAULT 0,
    estimated_cost_max INT DEFAULT 0,
    application_deadline VARCHAR(120),
    requirements_text TEXT
);

-- Some sample countries
INSERT INTO countries (name, min_cgpa, min_ielts, estimated_cost_min, estimated_cost_max, application_deadline, requirements_text)
VALUES
('Australia', 3.00, 6.5, 25000, 35000, 'November 30 for February intake',
 'Bachelor degree, English proficiency, financial proof'),
('Germany', 2.75, 6.0, 0, 15000, 'Varies by university',
 'Strong academic record, German/English proficiency, financial proof');

-- Scholarships (Scholarship matcher)
CREATE TABLE scholarships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    country VARCHAR(100) NOT NULL,
    min_cgpa DECIMAL(3,2) DEFAULT 0.00,
    min_ielts DECIMAL(3,1) DEFAULT 0.0,
    stipend_per_month INT DEFAULT 0,
    description TEXT,
    requires_research_proposal TINYINT(1) DEFAULT 0,
    requires_financial_proof TINYINT(1) DEFAULT 1
);

INSERT INTO scholarships
(name, country, min_cgpa, min_ielts, stipend_per_month, description, requires_research_proposal, requires_financial_proof)
VALUES
('DAAD Scholarship', 'Germany', 3.00, 6.5, 850, 'Excellent academic record, research proposal', 1, 1),
('Australia Future Leaders Scholarship', 'Australia', 3.20, 7.0, 1000, 'Leadership and academic excellence', 0, 1),
('Fulbright Foreign Student Program', 'USA', 3.50, 7.5, 2500, 'Fully funded masters or PhD programs in the United States.', 1, 0),
('Chevening Scholarship', 'UK', 3.30, 7.0, 1500, 'UK government’s global scholarship programme, funded by the Foreign, Commonwealth & Development Office.', 0, 0),
('Vanier Canada Graduate Scholarships', 'Canada', 3.70, 7.5, 4166, 'The Vanier CGS program aims to attract and retain world-class doctoral students.', 1, 0),
('Gates Cambridge Scholarship', 'UK', 3.80, 7.5, 1800, 'Scholarships for outstanding applicants from countries outside the UK to pursue a postgraduate degree at Cambridge.', 1, 0),
('Erasmus Mundus Joint Masters', 'Europe', 3.20, 6.5, 1200, 'High-level integrated study programmes, at master level, delivered by an international partnership of HEIs.', 0, 0),
('Knight-Hennessy Scholars', 'USA', 3.75, 7.5, 3000, 'The Knight-Hennessy Scholars program at Stanford University is a multidisciplinary community of future global leaders.', 0, 0),
('MEXT Scholarship', 'Japan', 3.00, 6.0, 1300, 'Monbukagakusho scholarship sponsored by the Japanese government for international students.', 0, 0),
('Destination Australia Scholarship', 'Australia', 3.00, 6.5, 1250, 'Support for international students to study in regional Australia.', 0, 1),
('Lester B. Pearson International Scholarship', 'Canada', 3.80, 7.5, 2000, 'Scholarship for exceptional international students at the University of Toronto.', 0, 0),
('Commonwealth Master’s Scholarship', 'UK', 3.50, 6.5, 1100, 'For candidates from low and middle income Commonwealth countries to undertake full-time taught Masters study.', 0, 1);

-- IELTS questions (IELTS Practice)
CREATE TABLE ielts_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    skill ENUM('Reading','Listening','Writing','Speaking') NOT NULL,
    difficulty ENUM('Easy','Medium','Hard') NOT NULL,
    question TEXT NOT NULL,
    option_a VARCHAR(255),
    option_b VARCHAR(255),
    option_c VARCHAR(255),
    option_d VARCHAR(255),
    correct_option CHAR(1) NOT NULL
);

INSERT INTO ielts_questions
(skill, difficulty, question, option_a, option_b, option_c, option_d, correct_option)
VALUES
('Reading','Medium','What is the main idea of the passage?', 'Details of research', 'Main argument', 'Background history', 'Author biography', 'B'),
('Reading','Medium','Which of the following best describes the author’s tone?', 'Neutral', 'Optimistic', 'Critical', 'Humorous', 'C');

-- IELTS results
CREATE TABLE ielts_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    skill ENUM('Reading','Listening','Writing','Speaking') NOT NULL,
    difficulty ENUM('Easy','Medium','Hard') NOT NULL,
    score INT NOT NULL,
    taken_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Chatbot simple log (optional)
CREATE TABLE chat_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    question TEXT,
    answer TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
