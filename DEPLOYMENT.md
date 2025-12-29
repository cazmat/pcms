# Production Deployment Checklist

## 📋 Pre-Deployment Checklist

### Server Requirements
- [ ] PHP 7.4 or higher installed
- [ ] MySQL 5.7+ or MariaDB 10.2+ installed
- [ ] Apache 2.4+ with mod_rewrite enabled OR Nginx 1.18+
- [ ] SSL/TLS certificate configured (HTTPS required for production)
- [ ] Sufficient disk space (minimum 500MB recommended)
- [ ] PHP extensions installed:
  - [ ] mysqli
  - [ ] pdo_mysql
  - [ ] session
  - [ ] json
  - [ ] mbstring

### Pre-Deployment Testing
- [ ] All features tested in staging environment
- [ ] Cross-browser compatibility verified (Chrome, Firefox, Safari, Edge)
- [ ] Mobile responsiveness tested
- [ ] Security scan completed (no critical vulnerabilities)
- [ ] Database backup tested and verified
- [ ] Admin login/logout tested
- [ ] Post CRUD operations tested
- [ ] Category and tag management tested
- [ ] Error pages (403, 404, 500) tested

## 🚀 Deployment Steps

### 1. Server Setup

#### Apache Configuration
```bash
# Enable required modules
sudo a2enmod rewrite
sudo a2enmod headers
sudo a2enmod deflate
sudo systemctl restart apache2

# Set proper permissions
sudo chown -R www-data:www-data /var/www/html/blog
sudo chmod -R 755 /var/www/html/blog
sudo chmod -R 775 /var/www/html/blog/includes/logs
```

#### Nginx Configuration
```bash
# Copy nginx configuration
sudo cp nginx.conf.example /etc/nginx/sites-available/blog
sudo ln -s /etc/nginx/sites-available/blog /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx

# Set proper permissions
sudo chown -R www-data:www-data /var/www/html/blog
sudo chmod -R 755 /var/www/html/blog
sudo chmod -R 775 /var/www/html/blog/includes/logs
```

### 2. File Deployment

- [ ] Upload all files to server via FTP/SFTP or git clone
- [ ] Exclude development files (.git, .gitignore, TODO.md, etc.)
- [ ] Verify file permissions:
  ```bash
  # Files: 644
  find . -type f -exec chmod 644 {} \;

  # Directories: 755
  find . -type d -exec chmod 755 {} \;

  # Logs directory: 775 (writable)
  chmod -R 775 includes/logs
  ```

### 3. Database Setup

- [ ] Create production database:
  ```sql
  CREATE DATABASE blog_production CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  CREATE USER 'blog_user'@'localhost' IDENTIFIED BY 'STRONG_PASSWORD_HERE';
  GRANT ALL PRIVILEGES ON blog_production.* TO 'blog_user'@'localhost';
  FLUSH PRIVILEGES;
  ```

- [ ] Run setup script:
  ```bash
  # Navigate to your blog URL
  https://yourdomain.com/setup.php

  # Follow setup wizard:
  # - Enter database credentials
  # - Create admin account
  # - Configure base URL
  ```

- [ ] **IMPORTANT**: Delete setup.php after completion:
  ```bash
  rm /var/www/html/blog/setup.php
  ```

### 4. Configuration

#### Environment Configuration
- [ ] Create `.env` file:
  ```bash
  cp .env.example .env
  ```

- [ ] Edit `.env` file:
  ```ini
  APP_ENV=production
  DB_HOST=localhost
  DB_NAME=blog_production
  DB_USER=blog_user
  DB_PASS=your_secure_password
  ```

#### Settings Configuration
- [ ] Log in to admin panel: `https://yourdomain.com/admin`
- [ ] Navigate to Settings page
- [ ] Configure all settings:
  - [ ] Site Name
  - [ ] Admin Email
  - [ ] Base URL (must include https://)
  - [ ] Timezone
  - [ ] Date Format
  - [ ] Posts Per Page
  - [ ] Social Media URLs
  - [ ] Allow Contact setting

#### Database Configuration
- [ ] Update `includes/db.php` with production credentials (if not using .env)
- [ ] Verify database connection works
- [ ] Test queries run successfully

### 5. Security Hardening

#### File Permissions
- [ ] Restrict access to sensitive files:
  ```bash
  chmod 640 includes/db.php
  chmod 640 includes/settings.php
  chmod 640 .env
  ```

- [ ] Protect configuration files via .htaccess (Apache):
  ```apache
  <Files "db.php">
    Require all denied
  </Files>
  <Files "settings.php">
    Require all denied
  </Files>
  <Files ".env">
    Require all denied
  </Files>
  ```

#### PHP Configuration
- [ ] Update `php.ini` for production:
  ```ini
  display_errors = Off
  display_startup_errors = Off
  error_reporting = E_ALL
  log_errors = On
  error_log = /var/log/php/error.log
  expose_php = Off
  session.cookie_httponly = 1
  session.cookie_secure = 1
  session.use_strict_mode = 1
  ```

#### SSL/HTTPS
- [ ] SSL certificate installed and verified
- [ ] Force HTTPS via .htaccess:
  ```apache
  RewriteCond %{HTTPS} !=on
  RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
  ```

- [ ] Verify HTTPS works on all pages
- [ ] Update base_url setting to use https://

#### Database Security
- [ ] Database user has minimum required privileges
- [ ] Database password is strong (16+ characters, mixed case, symbols)
- [ ] Remote database access disabled (localhost only)
- [ ] MySQL/MariaDB secured:
  ```bash
  sudo mysql_secure_installation
  ```

### 6. Performance Optimization

#### PHP Configuration
- [ ] Enable OPcache in `php.ini`:
  ```ini
  opcache.enable=1
  opcache.memory_consumption=128
  opcache.max_accelerated_files=10000
  opcache.revalidate_freq=2
  ```

#### Apache Configuration
- [ ] Enable compression in .htaccess:
  ```apache
  <IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/json
  </IfModule>
  ```

- [ ] Enable browser caching in .htaccess:
  ```apache
  <IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
  </IfModule>
  ```

### 7. Monitoring & Logging

#### Error Logging
- [ ] Verify log directory is writable:
  ```bash
  ls -la includes/logs/
  # Should show: drwxrwxr-x
  ```

- [ ] Test error logging by viewing admin logs page
- [ ] Set up log rotation if needed

#### Monitoring Setup
- [ ] Configure uptime monitoring (e.g., UptimeRobot, Pingdom)
- [ ] Set up error notification emails
- [ ] Configure database backup schedule
- [ ] Monitor disk space usage

## ✅ Post-Deployment Verification

### Functionality Testing
- [ ] Homepage loads correctly
- [ ] All blog posts display properly
- [ ] Post pagination works
- [ ] Category and tag filtering works
- [ ] Individual post pages load
- [ ] Admin login works
- [ ] Admin dashboard accessible
- [ ] Create new post works
- [ ] Edit existing post works
- [ ] Delete post works
- [ ] Category management works
- [ ] Tag management works
- [ ] Settings page loads and saves
- [ ] Error pages (403, 404, 500) display correctly

### Security Verification
- [ ] HTTPS works on all pages (no mixed content warnings)
- [ ] setup.php is deleted or inaccessible
- [ ] Database credentials are not exposed
- [ ] .env file is not accessible via browser
- [ ] Error messages don't reveal sensitive information
- [ ] SQL injection attempts are blocked
- [ ] XSS attempts are sanitized
- [ ] CSRF tokens are working on forms
- [ ] Session hijacking protections active
- [ ] Login rate limiting works (test 6+ failed attempts)

### Performance Verification
- [ ] Page load time < 2 seconds
- [ ] Images load efficiently
- [ ] No JavaScript errors in console
- [ ] No PHP errors in logs
- [ ] Database queries optimized (check slow query log)
- [ ] GZIP compression active (check headers)
- [ ] Browser caching active (check headers)

### SEO Verification
- [ ] robots.txt accessible and correct
- [ ] Meta descriptions present on all pages
- [ ] Page titles are SEO-friendly
- [ ] URLs are clean and descriptive
- [ ] SSL certificate valid and trusted

## 🔄 Backup Procedures

### Database Backup
```bash
# Manual backup
mysqldump -u blog_user -p blog_production > backup_$(date +%Y%m%d_%H%M%S).sql

# Automated daily backup (add to crontab)
0 2 * * * mysqldump -u blog_user -p'PASSWORD' blog_production > /backups/blog_$(date +\%Y\%m\%d).sql
```

### File Backup
```bash
# Backup files
tar -czf blog_backup_$(date +%Y%m%d_%H%M%S).tar.gz \
  /var/www/html/blog \
  --exclude='includes/logs/*'

# Automated weekly backup (add to crontab)
0 3 * * 0 tar -czf /backups/blog_files_$(date +\%Y\%m\%d).tar.gz /var/www/html/blog --exclude='includes/logs/*'
```

### Backup Verification
- [ ] Test database restore from backup
- [ ] Test file restore from backup
- [ ] Verify backups are stored off-site
- [ ] Document restore procedure

## 🚨 Rollback Plan

### If Deployment Fails
1. **Stop web server**
   ```bash
   sudo systemctl stop apache2
   # or
   sudo systemctl stop nginx
   ```

2. **Restore previous version**
   ```bash
   # Restore files
   tar -xzf blog_backup_YYYYMMDD.tar.gz -C /var/www/html/

   # Restore database
   mysql -u blog_user -p blog_production < backup_YYYYMMDD.sql
   ```

3. **Restart web server**
   ```bash
   sudo systemctl start apache2
   # or
   sudo systemctl start nginx
   ```

4. **Verify rollback successful**
   - Test homepage loads
   - Test admin access
   - Check error logs

## 📞 Support & Maintenance

### Regular Maintenance Tasks
- [ ] Daily: Check error logs
- [ ] Daily: Verify backups completed
- [ ] Weekly: Review security logs
- [ ] Weekly: Update dependencies
- [ ] Monthly: Security audit
- [ ] Monthly: Performance review
- [ ] Quarterly: Full security scan

### Emergency Contacts
- Server Administrator: _____________
- Database Administrator: _____________
- Security Team: _____________
- Hosting Support: _____________

### Useful Commands
```bash
# Check disk space
df -h

# Check database size
mysql -u blog_user -p -e "SELECT table_schema AS 'Database', ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS 'Size (MB)' FROM information_schema.TABLES WHERE table_schema = 'blog_production';"

# Check Apache/Nginx logs
tail -f /var/log/apache2/error.log
tail -f /var/log/nginx/error.log

# Check PHP-FPM logs (if applicable)
tail -f /var/log/php-fpm/error.log

# Monitor server resources
top
htop
```

## 🔐 Security Incident Response

### If Security Breach Detected
1. **Immediate Actions**
   - [ ] Take site offline (maintenance mode)
   - [ ] Change all passwords (database, admin, FTP, SSH)
   - [ ] Review access logs
   - [ ] Identify attack vector

2. **Investigation**
   - [ ] Check file modifications: `find . -type f -mtime -7`
   - [ ] Review database for unauthorized changes
   - [ ] Check error logs for suspicious activity
   - [ ] Scan for malware/backdoors

3. **Recovery**
   - [ ] Restore from clean backup
   - [ ] Patch vulnerability
   - [ ] Update all dependencies
   - [ ] Harden security configuration

4. **Post-Incident**
   - [ ] Document incident
   - [ ] Implement additional security measures
   - [ ] Notify affected users (if applicable)
   - [ ] Review and update security policies

## 📝 Deployment Completion

### Final Checklist
- [ ] All deployment steps completed
- [ ] All post-deployment tests passed
- [ ] Backups configured and tested
- [ ] Monitoring active
- [ ] Documentation updated
- [ ] Team notified of deployment
- [ ] Rollback plan documented and tested

### Sign-Off
- Deployed by: ________________
- Date: ________________
- Version: ________________
- Environment: Production
- Status: ☐ Success ☐ Failed ☐ Rolled Back

---

**Document Version**: 1.0
**Last Updated**: 2025-12-29
**Next Review**: Quarterly or after major changes
