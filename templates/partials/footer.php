<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-section footer-about">
                <h3>{{ $system->get_setting("site_name") }}</h3>
                <p>A modern blog platform built with PHP, focusing on simplicity and performance.</p>
            </div>

            <div class="footer-section footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="{{ $system->get_setting('base_url') }}">Home</a></li>
                    <li><a href="{{ $system->get_setting('base_url') }}/admin/index.php">Admin</a></li>
                </ul>
            </div>

            <div class="footer-section footer-social">
                <h4>Connect</h4>
                <div class="social-links">
                    <a href="https://twitter.com" target="_blank" rel="noopener" aria-label="Twitter">
                        <i class="bi bi-twitter-x"></i>
                    </a>
                    <a href="https://github.com" target="_blank" rel="noopener" aria-label="GitHub">
                      <i class="bi bi-github"></i>
                    </a>
                    <a href="https://linkedin.com" target="_blank" rel="noopener" aria-label="LinkedIn">
                        <i class="bi bi-linkedin"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> {{ $system->get_setting("site_name") }}. All rights reserved.</p>
        </div>
    </div>
</footer>
