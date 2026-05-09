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
('Australia', 3.00, 6.5, 25000, 35000, 'November 30 for February intake', 'Bachelor degree, English proficiency, financial proof'),
('Germany', 2.75, 6.0, 0, 15000, 'Varies by university', 'Strong academic record, German/English proficiency, financial proof'),
('USA', 3.20, 7.0, 40000, 60000, 'December-January', 'SAT/GRE/GMAT, SOP, LORs, Financial proof'),
('UK', 3.00, 6.5, 20000, 35000, 'January-June', 'Bachelor degree, SOP, LORs, UKVI IELTS'),
('Canada', 3.00, 6.5, 15000, 30000, 'January-March', 'Study permit, Financial proof, SOP'),
('Japan', 2.80, 6.0, 10000, 20000, 'April/October intake', 'JLPT/EJU might be needed, High school diploma'),
('France', 2.75, 6.0, 5000, 15000, 'Varies', 'Campus France procedure, French/English proficiency');

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
('Commonwealth Master’s Scholarship', 'UK', 3.50, 6.5, 1100, 'For candidates from low and middle income Commonwealth countries to undertake full-time taught Masters study.', 0, 1),
('Swedish Institute Scholarships', 'Sweden', 3.30, 6.5, 1100, 'For global professionals to study masters in Sweden.', 0, 0),
('Eiffel Excellence Scholarship', 'France', 3.50, 6.5, 1200, 'Developed by the Ministry for Europe and Foreign Affairs to attract top foreign students.', 0, 0),
('Swiss Government Excellence Scholarships', 'Switzerland', 3.70, 7.0, 1900, 'For foreign researchers and artists.', 1, 0),
('Singapore International Graduate Award (SINGA)', 'Singapore', 3.60, 6.5, 2000, 'PhD scholarships for international students in Science and Engineering.', 1, 0),
('Orange Knowledge Programme', 'Netherlands', 3.00, 6.0, 1000, 'Mid-career professional development in various fields.', 0, 0),
('Schwarzman Scholars', 'China', 3.50, 7.5, 2500, 'Masters in Global Affairs at Tsinghua University.', 0, 0),
('Rhodes Scholarship', 'UK', 3.90, 7.5, 1600, 'The oldest and perhaps most prestigious international scholarship program.', 1, 0),
('KAIST International Student Scholarship', 'South Korea', 3.40, 6.0, 300, 'Full tuition and monthly allowance for undergraduate and graduate students.', 0, 0),
('Turkey Scholarships (Türkiye Bursları)', 'Turkey', 3.00, 5.5, 500, 'Government-funded, competitive scholarship program for international students.', 0, 0),
('HKPFS (Hong Kong PhD Fellowship Scheme)', 'Hong Kong', 3.70, 7.0, 3300, 'Established by the RGC to attract the best and brightest students in the world.', 1, 0);

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
('Reading','Medium','Which of the following best describes the author’s tone?', 'Neutral', 'Optimistic', 'Critical', 'Humorous', 'C'),
('Listening','Easy','What time does the train leave?', '10:00 AM', '10:15 AM', '10:30 AM', '10:45 AM', 'B'),
('Writing','Hard','Discuss the pros and cons of remote work.', '', '', '', '', 'A'),
('Speaking','Medium','Describe a book you recently read.', '', '', '', '', 'A'),
('Reading','Hard','The term "sustainable development" was popularized by...', 'The UN', 'The World Bank', 'Brundtland Report', 'Greenpeace', 'C'),
('Listening','Medium','Where is the conference being held?', 'Main Hall', 'Exhibition Center', 'University Library', 'Town Hall', 'B'),
('Listening','Hard','What is the speakers opinion on the new policy?', 'Strongly supports', 'Cautiously optimistic', 'Skeptical', 'Indifferent', 'C'),
('Reading','Easy','The passage mentions that the climate in the region is...', 'Arid', 'Tropical', 'Temperate', 'Polar', 'C'),
('Reading','Medium','Which paragraph discusses the economic impact?', 'Paragraph 2', 'Paragraph 4', 'Paragraph 5', 'Paragraph 7', 'B'),
('Reading','Hard','In line 24, the word "mitigate" most nearly means...', 'Aggravate', 'Alleviate', 'Evaluate', 'Coordinate', 'B'),
('Listening','Easy','How much is the membership fee?', '$25', '$40', '$50', '$60', 'C'),
('Listening','Medium','The student needs to finish the assignment by...', 'Friday', 'Monday', 'Wednesday', 'Tuesday', 'B'),
('Reading','Easy','True or False: The company was founded in 1995.', 'True', 'False', '', '', 'A'),
('Reading','Medium','Which of the following was NOT mentioned as a benefit?', 'Cost-saving', 'Efficiency', 'Health', 'Speed', 'C'),
('Reading','Hard','The author implies that the future of AI will depend on...', 'Regulation', 'Hardware', 'Data quality', 'Public trust', 'A');

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

-- University applications
CREATE TABLE IF NOT EXISTS university_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    university_name VARCHAR(150) NOT NULL,
    country VARCHAR(100),
    program VARCHAR(150),
    stage ENUM('shortlisted','in_progress','submitted','accepted','rejected') DEFAULT 'shortlisted',
    notes TEXT,
    deadline DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Visa questions
CREATE TABLE IF NOT EXISTS visa_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    tip TEXT NOT NULL,
    category VARCHAR(60) DEFAULT 'General'
);

INSERT INTO visa_questions (question, tip, category) VALUES
('Why did you choose this specific university?', 'Research the universitys strong programs, global rankings, and faculty. Mention specific courses or professors that align with your goals.', 'Academics'),
('Why do you want to study abroad instead of staying in your home country?', 'Emphasize global exposure, specialized programs not available locally, and your long-term career goals.', 'Motivation'),
('What are your plans after completing your studies?', 'Always state your intention to return home and contribute to your countrys development. Mention specific career plans.', 'Post-Study'),
('Who is funding your studies?', 'Be clear and confident. Mention your sponsor (parents, scholarship, self) and show financial documents if asked.', 'Financial'),
('Have you previously applied for a visa to any country?', 'Be honest. If you had rejections, explain the reason and what has changed. Do not lie, as it can cause permanent bans.', 'History'),
('What is your IELTS score and how will you manage language barriers?', 'State your score confidently, mention any English courses you have taken, and describe daily English usage habits.', 'Language'),
('Do you have any relatives or friends in the destination country?', 'Being honest is key. If yes, clarify they will not influence you to stay illegally.', 'Personal'),
('What is your accommodation arrangement?', 'Mention university dormitory, pre-arranged rental, or homestay. Having confirmed accommodation shows preparedness.', 'Logistics'),
('What if your visa is rejected?', 'Explain that you would respect the decision and carefully review the reasons for rejection to see if you can address them in a future application.', 'Refusal'),
('Can you name some of the modules in your chosen course?', 'Demonstrate that you have researched your program thoroughly by naming at least 3-4 specific subjects or modules.', 'Academic Research'),
('Why did you not choose other countries like Canada or the UK?', 'Highlight unique aspects of the destination country, its industry specialization, or the specific university reputation.', 'Comparison'),
('How will this degree help you in your home country?', 'Connect the skills you will gain to specific growing industries or challenges in your home country.', 'Career Goals'),
('Do you plan to work while studying?', 'While you are allowed to work part-time (usually 20 hrs/week), emphasize that your primary focus is your education and that you have sufficient funds without working.', 'Intentions');

-- Universities table
CREATE TABLE IF NOT EXISTS universities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    country VARCHAR(100) NOT NULL,
    min_cgpa DECIMAL(3,2) DEFAULT 0.00,
    min_ielts DECIMAL(3,1) DEFAULT 0.0,
    program_areas TEXT,
    type ENUM('Safe','Target','Reach') DEFAULT 'Target'
);

INSERT INTO universities (name, country, min_cgpa, min_ielts, program_areas, type) VALUES
('University of Melbourne', 'Australia', 3.50, 7.0, 'Engineering, Business, Medicine, Arts', 'Reach'),
('Australian National University', 'Australia', 3.30, 6.5, 'Science, Law, Economics, Computing', 'Reach'),
('Deakin University', 'Australia', 2.75, 6.0, 'Nursing, Business, IT, Education', 'Safe'),
('RMIT University', 'Australia', 3.00, 6.5, 'Design, Engineering, Business', 'Target'),
('TU Munich', 'Germany', 3.50, 6.5, 'Engineering, Computer Science, Physics', 'Reach'),
('RWTH Aachen University', 'Germany', 3.20, 6.0, 'Engineering, Mathematics, Natural Sciences', 'Target'),
('Heidelberg University', 'Germany', 3.30, 6.5, 'Medicine, Biology, Chemistry', 'Reach'),
('Hochschule Munich', 'Germany', 2.80, 6.0, 'Applied Sciences, Business, Social Work', 'Safe'),
('University of Toronto', 'Canada', 3.70, 7.5, 'Computer Science, Medicine, Law, Engineering', 'Reach'),
('McGill University', 'Canada', 3.60, 7.0, 'Medicine, Arts, Science, Management', 'Reach'),
('University of British Columbia', 'Canada', 3.40, 6.5, 'Sustainability, Forestry, Business, Engineering', 'Target'),
('Seneca College', 'Canada', 2.50, 6.0, 'Applied Arts, Technology, Business', 'Safe'),
('Humber College', 'Canada', 2.60, 6.0, 'Media, IT, Health Sciences', 'Safe'),
('University of Oxford', 'UK', 3.85, 7.5, 'Philosophy, Politics, Medicine, Humanities', 'Reach'),
('Imperial College London', 'UK', 3.75, 7.0, 'Science, Engineering, Medicine, Business', 'Reach'),
('University of Manchester', 'UK', 3.20, 6.5, 'Physics, Social Sciences, Engineering', 'Target'),
('Coventry University', 'UK', 2.70, 6.0, 'Automotive Design, Business, Arts', 'Safe'),
('Stanford University', 'USA', 3.90, 7.5, 'CS, AI, Entrepreneurship, Law', 'Reach'),
('Harvard University', 'USA', 3.95, 7.5, 'Law, Medicine, Business, Public Policy', 'Reach'),
('UC Berkeley', 'USA', 3.65, 7.0, 'STEM, Social Sciences, Chemistry', 'Reach'),
('Arizona State University', 'USA', 2.80, 6.5, 'Innovation, Business, Engineering', 'Safe'),
('University of Tokyo', 'Japan', 3.50, 6.5, 'Physics, Engineering, Medicine', 'Reach'),
('Kyoto University', 'Japan', 3.40, 6.0, 'Science, Philosophy, Agriculture', 'Reach'),
('National University of Singapore', 'Singapore', 3.70, 7.0, 'CS, Data Science, Business, Bioengineering', 'Reach');
