-- Migration: Add Categories and Tags System
-- Run this migration to add categories and tags functionality to the blog system

USE blog_system;

-- Categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    color VARCHAR(7) DEFAULT '#3B82F6',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tags table
CREATE TABLE IF NOT EXISTS tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    color VARCHAR(7) DEFAULT '#8B5CF6',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Post-Tag junction table (many-to-many relationship)
CREATE TABLE IF NOT EXISTS post_tags (
    post_id INT NOT NULL,
    tag_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (post_id, tag_id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE,
    INDEX idx_post_id (post_id),
    INDEX idx_tag_id (tag_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add category_id column to posts table
ALTER TABLE posts
ADD COLUMN category_id INT NULL AFTER author,
ADD FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
ADD INDEX idx_category_id (category_id);

-- Insert default "Uncategorized" category
INSERT INTO categories (name, slug, color)
VALUES ('Uncategorized', 'uncategorized', '#6B7280')
ON DUPLICATE KEY UPDATE name = name;

-- Update existing posts to use the "Uncategorized" category
UPDATE posts
SET category_id = (SELECT id FROM categories WHERE slug = 'uncategorized')
WHERE category_id IS NULL;

-- Insert sample categories
INSERT INTO categories (name, slug, color) VALUES
('Technology', 'technology', '#3B82F6'),
('Programming', 'programming', '#8B5CF6'),
('Tutorials', 'tutorials', '#10B981')
ON DUPLICATE KEY UPDATE name = name;

-- Insert sample tags
INSERT INTO tags (name, slug, color) VALUES
('PHP', 'php', '#8B5CF6'),
('MySQL', 'mysql', '#F59E0B'),
('Web Development', 'web-development', '#10B981'),
('Tutorial', 'tutorial', '#EC4899'),
('Beginner', 'beginner', '#6366F1')
ON DUPLICATE KEY UPDATE name = name;

-- Associate sample tags with existing posts
-- Post 1: "Welcome to My Blog" - Uncategorized
INSERT INTO post_tags (post_id, tag_id)
SELECT 1, id FROM tags WHERE slug IN ('web-development', 'beginner')
ON DUPLICATE KEY UPDATE post_id = post_id;

-- Post 2: "Getting Started with PHP" - Programming
INSERT INTO post_tags (post_id, tag_id)
SELECT 2, id FROM tags WHERE slug IN ('php', 'tutorial', 'beginner')
ON DUPLICATE KEY UPDATE post_id = post_id;

UPDATE posts
SET category_id = (SELECT id FROM categories WHERE slug = 'programming')
WHERE slug = 'getting-started-with-php';

-- Post 3: "Building a Blog with PHP" - Tutorials
INSERT INTO post_tags (post_id, tag_id)
SELECT 3, id FROM tags WHERE slug IN ('php', 'mysql', 'tutorial', 'web-development')
ON DUPLICATE KEY UPDATE post_id = post_id;

UPDATE posts
SET category_id = (SELECT id FROM categories WHERE slug = 'tutorials')
WHERE slug = 'building-a-blog-with-php';
