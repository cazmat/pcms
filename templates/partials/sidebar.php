<aside class="sidebar">
<?php
  $insta = $system->get_setting("social_insta");
  $twitch = $system->get_setting("social_twitch");
  if(empty($insta)) $insta = null;
  if(empty($twitch)) $twitch = null;
  if($insta !== null && $twitch !== null) {
?>
    <!-- Social Links Widget -->
    <div class="widget widget-social">
        <h3 class="widget-title">Follow Us</h3>
        <div class="social-links-sidebar">
<?php
  if($insta !== null && $insta) {
?>
            <a href="{{  $system->get_setting('social_insta') }}" target="_blank" rel="noopener" class="social-link">
              <i class="bi bi-instagram"></i> Instagram
            </a>
<?php
  }
  if($system->get_setting("social_twitch") !== null && !empty($system->get_setting("social_twitch"))) {
?>
            <a href="{{  $system->get_setting('social_twitch') }}" target="_blank" rel="noopener" class="social-link">
              <i class="bi bi-twitch"></i> Twitch
            </a>
<?php
  }
?>
        </div>
    </div>
<?php
}
?>
</aside>
