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
├── includes/          # Core PHP files
│   ├── config.php     # Configuration settings
│   ├── db.php         # Database connection
│   └── functions.php  # Helper functions
├── css/               # Stylesheets
│   └── style.css      # Main stylesheet
├── sql/               # Database scripts
│   └── setup.sql      # Database setup script
├── index.php          # Homepage (list all posts)
├── post.php           # Single post view
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

### 2. Configure Database Connection

Edit `includes/config.php` and update these values for your environment:

```php
define('DB_HOST', 'localhost');     // Your database host
define('DB_USER', 'root');          // Your database username
define('DB_PASS', '');              // Your database password
define('DB_NAME', 'blog_system');   // Database name
```

**Note**: Make sure your MySQL/MariaDB server is running and the user has permissions to create databases.

### 3. Start the Web Server

Option A: Using PHP built-in server (for development):
```bash
php -S localhost:8000
```

Option B: Using Apache/Nginx:
- Point your virtual host document root to the project root directory
- Ensure `.htaccess` is supported (Apache) or configure URL rewriting (Nginx)

### 4. Run the Setup Script

1. Navigate to http://localhost:8000/setup.php in your browser
2. Review the database configuration
3. Create your admin account:
   - Enter a username (at least 3 characters)
   - Optionally enter an email address
   - Create a secure password (at least 6 characters)
   - Confirm your password
4. Click "Create Admin Account & Set Up Database"

The setup script will:
- Create the database and all required tables
- Create your admin account with secure password hashing
- Insert 3 sample blog posts

### 5. Access the Blog

- **Homepage**: http://localhost:8000/
- **Admin Login**: http://localhost:8000/admin/login.php

**Security Note**: After successful setup, consider deleting or restricting access to `setup.php` to prevent unauthorized access.

## Authentication

The admin panel is protected by a secure authentication system.

### Login Credentials

Your admin credentials are set during the initial setup process when you run `setup.php`. Use the username and password you created to log in to the admin panel.

### Features

- **Secure Password Hashing**: Passwords are hashed using bcrypt
- **Session Management**: Secure PHP sessions with regeneration
- **Remember Me**: Optional 30-day persistent login via secure tokens
- **Rate Limiting**: Maximum 5 login attempts per 15 minutes per IP address
- **Auto-cleanup**: Expired tokens and old login attempts are automatically cleaned

### Logging In

1. Navigate to http://localhost:8000/admin/index.php
2. You'll be redirected to the login page
3. Enter your username and password
4. Optionally check "Remember me for 30 days" for persistent login
5. Click "Log In"

### Logging Out

Click the "Log Out" link in the admin panel navigation.

### Security Notes

- All admin pages require authentication
- Sessions are regenerated on login to prevent session fixation
- Remember tokens are stored securely in the database
- Login attempts are rate-limited to prevent brute force attacks
- All passwords are hashed with bcrypt (cost factor 10)

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

### Users Table

| Column     | Type          | Description                          |
|------------|---------------|--------------------------------------|
| id         | INT           | Primary key (auto-increment)         |
| username   | VARCHAR(50)   | Unique username                      |
| password   | VARCHAR(255)  | Bcrypt hashed password               |
| email      | VARCHAR(255)  | Email address                        |
| created_at | TIMESTAMP     | Account creation date                |
| updated_at | TIMESTAMP     | Last update date                     |

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

### Remember Tokens Table

| Column     | Type          | Description                          |
|------------|---------------|--------------------------------------|
| id         | INT           | Primary key (auto-increment)         |
| user_id    | INT           | Foreign key to users table           |
| token      | VARCHAR(64)   | Unique remember token                |
| expires_at | TIMESTAMP     | Token expiration time                |
| created_at | TIMESTAMP     | Token creation date                  |

### Login Attempts Table

| Column       | Type          | Description                          |
|--------------|---------------|--------------------------------------|
| id           | INT           | Primary key (auto-increment)         |
| ip_address   | VARCHAR(45)   | IP address of attempt                |
| username     | VARCHAR(50)   | Attempted username                   |
| attempted_at | TIMESTAMP     | Time of attempt                      |

## Security Considerations

### Implemented Security Features

- ✅ **User authentication system** - Bcrypt password hashing, secure sessions
- ✅ **Password protection for admin panel** - All admin pages require login
- ✅ **Rate limiting** - 5 login attempts per 15 minutes per IP
- ✅ **Session security** - Session regeneration on login, secure cookies
- ✅ **SQL injection prevention** - Using MySQLi prepared statements
- ✅ **XSS prevention** - HTML escaping for all user output
- ✅ **Input validation** - Server-side validation for all forms
- ✅ **Security headers** - X-Frame-Options, X-Content-Type-Options, X-XSS-Protection
- ✅ **Directory protection** - Blocks access to sensitive directories (.git, includes, sql)
- ✅ **Error handling** - Custom error pages without information disclosure

### For Production Use, Consider Adding

- [ ] CSRF protection for forms
- [ ] HTTPS enforcement
- [ ] Content Security Policy (CSP) header
- [ ] File upload validation (if adding images)
- [ ] Security audit and penetration testing
- [ ] Regular security updates

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

## Clean URLs (Pretty URLs)

The blog system includes support for clean, SEO-friendly URLs.

### URL Structure

**Public URLs:**
- Homepage: `/` (instead of `/index.php`)
- Single Post: `/post/slug-name` (instead of `/post.php?slug=slug-name`)

**Admin URLs:**
- Admin Dashboard: `/admin` (instead of `/admin/index.php`)
- Login: `/admin/login` (instead of `/admin/login.php`)
- Logout: `/admin/logout` (instead of `/admin/logout.php`)
- Create Post: `/admin/edit` (instead of `/admin/edit.php`)
- Edit Post: `/admin/edit/123` (instead of `/admin/edit.php?id=123`)

### Apache Setup

The `.htaccess` file is included and enabled by default. It provides:
- Clean URLs with `.php` extension removal
- Blog post URL rewriting (`/post/slug-name`)
- Admin URL rewriting
- Security headers (X-Frame-Options, X-Content-Type-Options, etc.)
- GZIP compression
- Browser caching
- Protection for sensitive directories

**Requirements:**
- Apache with `mod_rewrite` enabled
- `AllowOverride All` in your Apache configuration

**Enable mod_rewrite (if needed):**
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### Nginx Setup

An example Nginx configuration is provided in `nginx.conf.example`.

**To use it:**
1. Copy to Nginx sites directory:
   ```bash
   sudo cp nginx.conf.example /etc/nginx/sites-available/blog
   ```
2. Edit the file and update:
   - `server_name` with your domain
   - `root` with your installation path
   - PHP-FPM socket path if needed
3. Enable the site:
   ```bash
   sudo ln -s /etc/nginx/sites-available/blog /etc/nginx/sites-enabled/
   sudo nginx -t
   sudo systemctl reload nginx
   ```

### Blocking setup.php After Installation

For security, block access to `setup.php` after completing installation:

**Apache (.htaccess):**
Uncomment this line in `.htaccess`:
```apache
# RewriteRule ^setup\.php$ - [F,L]
```

**Nginx:**
Uncomment this block in your Nginx config:
```nginx
# location = /setup.php {
#     deny all;
#     return 404;
# }
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
