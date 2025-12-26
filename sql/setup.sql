-- Blog System Database Setup
-- Create database and tables for the PHP blog system

CREATE DATABASE IF NOT EXISTS blog_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE blog_system;

-- Posts table
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content TEXT NOT NULL,
    excerpt VARCHAR(500),
    author VARCHAR(100) NOT NULL,
    status ENUM('draft', 'published') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample data
INSERT INTO posts (title, slug, content, excerpt, author, status) VALUES
('Welcome to My Blog', 'welcome-to-my-blog',
'<p>Welcome to my new blog! This is my first post and I\'m excited to share my thoughts with you.</p><p>This blog is built using PHP and MySQL, providing a simple but effective platform for sharing content.</p><p>Stay tuned for more posts!</p>',
'Welcome to my new blog! This is my first post and I\'m excited to share my thoughts with you.',
'Admin', 'published'),

('Getting Started with PHP', 'getting-started-with-php',
'<p>PHP is a popular server-side scripting language that powers millions of websites worldwide.</p><p>In this post, we\'ll explore the basics of PHP and why it\'s a great choice for web development.</p><p>PHP is easy to learn, widely supported, and integrates seamlessly with databases like MySQL.</p>',
'Learn the basics of PHP and discover why it\'s such a popular choice for web development.',
'Admin', 'published'),

('Building a Blog with PHP', 'building-a-blog-with-php',
'<p>Creating a blog system is a great way to learn PHP and database integration.</p><p>In this tutorial series, we\'ll build a complete blog from scratch, including features like:</p><ul><li>Post creation and editing</li><li>Database integration</li><li>Clean URL slugs</li><li>Responsive design</li></ul>',
'Learn how to build a complete blog system using PHP and MySQL from scratch.',
'Admin', 'draft');
