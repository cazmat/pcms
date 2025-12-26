# PHP Blog System

A simple, clean, and functional blog system built with PHP and MySQL. Perfect for learning PHP basics or as a starting point for your own blog project.

## Features

- 📝 Create, Read, Update, and Delete blog posts
- 🎨 Clean and responsive design
- 📱 Mobile-friendly interface
- 🔐 Draft and published post statuses
- 🔗 SEO-friendly URL slugs
- 👤 Author attribution
- 📅 Automatic timestamps
- 🎯 Simple admin panel

## Project Structure

```
pcms/
├── admin/              # Admin panel
│   ├── index.php      # Manage posts
│   └── edit.php       # Create/edit posts
├── public/            # Public-facing pages
│   ├── index.php      # Homepage (list all posts)
│   └── post.php       # Single post view
├── includes/          # Core PHP files
│   ├── config.php     # Configuration settings
│   ├── db.php         # Database connection
│   └── functions.php  # Helper functions
├── css/               # Stylesheets
│   └── style.css      # Main stylesheet
├── sql/               # Database scripts
│   └── setup.sql      # Database setup script
└── README.md          # This file
```

## Requirements

- PHP 7.4 or higher
- MySQL 5.7+ or MariaDB 10.2+
- Web server (Apache, Nginx, or PHP built-in server)

## Installation

### 1. Clone or Download the Project

```bash
cd /path/to/your/webroot
git clone <repository-url> pcms
cd pcms
```

### 2. Set Up the Database

Option A: Using MySQL command line:
```bash
mysql -u root -p < sql/setup.sql
```

Option B: Using phpMyAdmin:
1. Open phpMyAdmin
2. Click "Import"
3. Select `sql/setup.sql`
4. Click "Go"

### 3. Configure Database Connection

Edit `includes/config.php` and update these values if needed:

```php
define('DB_HOST', 'localhost');     // Your database host
define('DB_USER', 'root');          // Your database username
define('DB_PASS', '');              // Your database password
define('DB_NAME', 'blog_system');   // Database name
```

### 4. Start the Web Server

Option A: Using PHP built-in server (for development):
```bash
cd public
php -S localhost:8000
```

Option B: Using Apache/Nginx:
- Point your virtual host document root to the `public/` directory
- Ensure `.htaccess` is supported (Apache) or configure URL rewriting (Nginx)

### 5. Access the Blog

- **Homepage**: http://localhost:8000/ (or your configured domain)
- **Admin Panel**: http://localhost:8000/../admin/index.php

## Usage

### Viewing Posts

1. Navigate to the homepage to see all published posts
2. Click on any post title or "Read more" to view the full post

### Managing Posts

1. Go to the Admin Panel
2. Click "Create New Post" to add a new post
3. Fill in the form:
   - **Title**: The post title (required)
   - **Excerpt**: A short summary (optional)
   - **Content**: The full post content (required, HTML allowed)
   - **Author**: Author name (required)
   - **Status**: Draft or Published

4. Click "Create Post" or "Update Post"

### Editing Posts

1. In the Admin Panel, click "Edit" next to any post
2. Modify the fields as needed
3. Click "Update Post"

### Deleting Posts

1. In the Admin Panel, click "Delete" next to any post
2. Confirm the deletion

## Database Schema

### Posts Table

| Column     | Type          | Description                          |
|------------|---------------|--------------------------------------|
| id         | INT           | Primary key (auto-increment)         |
| title      | VARCHAR(255)  | Post title                           |
| slug       | VARCHAR(255)  | URL-friendly version of title        |
| content    | TEXT          | Post content (HTML allowed)          |
| excerpt    | VARCHAR(500)  | Short summary                        |
| author     | VARCHAR(100)  | Author name                          |
| status     | ENUM          | 'draft' or 'published'               |
| created_at | TIMESTAMP     | Post creation date                   |
| updated_at | TIMESTAMP     | Last update date                     |

## Security Considerations

This is a basic blog system designed for learning purposes. For production use, consider adding:

- ✅ User authentication system
- ✅ Input validation and sanitization (partially implemented)
- ✅ CSRF protection
- ✅ XSS prevention (basic escaping included)
- ✅ SQL injection prevention (using PDO prepared statements)
- ✅ Password protection for admin panel
- ✅ HTTPS enforcement
- ✅ File upload validation (if adding images)

## Customization

### Changing Site Name

Edit `includes/config.php`:
```php
define('SITE_NAME', 'Your Blog Name');
```

### Styling

Edit `css/style.css` to customize colors, fonts, and layout.

### Posts Per Page

Edit `includes/config.php`:
```php
define('POSTS_PER_PAGE', 10);
```

## Sample Data

The setup script includes 3 sample posts:
- 2 published posts (visible on homepage)
- 1 draft post (only visible in admin panel)

Feel free to delete or modify these posts through the admin panel.

## Troubleshooting

### Database Connection Error

- Verify database credentials in `includes/config.php`
- Ensure MySQL/MariaDB is running
- Check if the database `blog_system` exists

### Posts Not Displaying

- Check if posts are marked as "published" (not "draft")
- Verify database connection is working
- Check browser console for JavaScript errors

### Permission Issues

- Ensure the web server has read access to all files
- Check file permissions: `chmod -R 755 pcms`

## Future Enhancements

Possible features to add:

- 📸 Image upload support
- 🏷️ Categories and tags
- 💬 Comments system
- 🔍 Search functionality
- 📄 Pagination
- 👥 Multi-user support with authentication
- 📧 Email notifications
- 🌐 Multilingual support
- 📊 Analytics dashboard

## License

This project is open source and available for educational purposes.

## Contributing

Contributions are welcome! Feel free to submit pull requests or open issues for bugs and feature requests.

## Support

For questions or issues, please open an issue on the project repository.

---

Built with ❤️ using PHP and MySQL
