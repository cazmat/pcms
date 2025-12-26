<?php
  class System {
    private $settings;
    function __construct() {
      $this->load_settings;
    }
    public function load_settings() {
      require_once(ROOT_PATH ."includes/settings.php");
      $this->settings = $settings;
    }
    public function get_settings($key) {
      // TODO: Return settings value for $key
    }
    public function save_settings() {
      // TODO: Save settings to "/include/settings.php".
    }
  }
?>