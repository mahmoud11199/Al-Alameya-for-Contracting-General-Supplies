CREATE TABLE roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  role_id INT NOT NULL,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_users_role_id (role_id),
  FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE services (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(180) NOT NULL,
  summary VARCHAR(255) NOT NULL,
  details TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE projects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(180) NOT NULL,
  summary VARCHAR(255) NOT NULL,
  location VARCHAR(180) DEFAULT NULL,
  completed_at DATE DEFAULT NULL,
  image VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_projects_completed_at (completed_at)
);

CREATE TABLE blog_posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(180) NOT NULL,
  excerpt VARCHAR(255) NOT NULL,
  body TEXT NOT NULL,
  status ENUM('draft','published') DEFAULT 'draft',
  published_at DATETIME DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_blog_status_published (status, published_at)
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(150) NOT NULL,
  phone VARCHAR(50) DEFAULT NULL,
  subject VARCHAR(180) DEFAULT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_messages_created_at (created_at)
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE settings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  setting_key VARCHAR(120) NOT NULL UNIQUE,
  setting_value TEXT NOT NULL
);

INSERT INTO roles (name) VALUES ('Admin'), ('Editor');
INSERT INTO users (role_id, name, email, password) VALUES
(1, 'System Administrator', 'admin@alameya.local', '$2y$10$VaWUQeXWqW6gXhNLeD0wOePH8f77j6Mj.tEOYg4pc5ynw90fY7uX2');

INSERT INTO settings (setting_key, setting_value) VALUES
('site_name', 'Al Alameya for Contracting & General Supplies'),
('phone', '+20 100 000 0000'),
('email', 'info@alameya.example'),
('address', 'Cairo, Egypt');

INSERT INTO services (title, summary, details) VALUES
('Civil Contracting', 'End-to-end civil and structural execution.', 'Industrial, commercial, and infrastructure projects delivered with strict QA/QC processes.'),
('MEP Works', 'Integrated mechanical, electrical, and plumbing services.', 'Design coordination, installation, testing, and commissioning by certified teams.'),
('General Supplies', 'Strategic sourcing and supply chain solutions.', 'Reliable procurement for project-critical materials and operational consumables.');

INSERT INTO projects (title, summary, location, completed_at, image) VALUES
('Regional Logistics Hub', 'Turnkey civil and MEP package for logistics center.', 'Cairo', '2024-10-15', NULL),
('Water Utility Upgrade', 'Network rehabilitation and pump station support.', 'Giza', '2023-08-01', NULL);

INSERT INTO blog_posts (title, excerpt, body, status, published_at) VALUES
('Safety Excellence Milestone', 'Al Alameya records 1M safe man-hours.', 'Our teams achieved a major HSE milestone...', 'published', NOW()),
('Procurement Digitization', 'How we reduced lead times by 22%.', 'A closer look at our supplier collaboration model...', 'published', NOW());
