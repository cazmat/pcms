<?php
  $connect = array();
  if($system->get_setting("allow_contact")) {
    $connect[] = array(
      "href" => "",
      "icon" => '<i class="bi bi-envelope-fill"></i>',
      "target" => "",
      "label" => "Contact Me"
    );
  }
  $github = $system->get_setting("social_github");
  if(!empty($github)) {
    $connect[] = array(
      "href" => $github,
      "icon" => '<i class="bi bi-github"></i>',
      "target" => "",
      "label" => "Github"
    );
  }
  $twitch = $system->get_setting("social_twitch");
  if(!empty($twitch)) {
    $connect[] = array(
      "href" => $twitch,
      "icon" => '<i class="bi bi-twitch"></i>',
      "target" => "",
      "label" => "Twitch"
    );
  }
?>

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
                    <li><a href="{{ $system->get_setting('base_url') }}/admin/">Admin</a></li>
                </ul>
            </div>
<?php
  if(count($connect) >= 1) {
?>
      <div class='footer-section footer-social'>
        <h4>Connect</h4>
        <div class='social-links'>
<?php
    foreach($connect as $c) {
?>
          <a href="<?php echo $c['href']; ?>" target="<?php echo $c['target']; ?>" rel="noopener" aria-label="<?php echo $c['label']; ?>">
            <?php echo $c['icon']; ?>
          </a>
<?php
    }
?>
        </div>
      </div>
<?php
  }
?>
    </div>
    <div class="footer-bottom">
      <p>&copy; <?php echo date('Y'); ?> <span class='hidden-xs'>{{ $system->get_setting("site_name") }}. All rights reserved.</span></p>
    </div>
  </div>
</footer>
