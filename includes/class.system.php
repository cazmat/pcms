<?php
  class System {
    private $settings;
    function __construct() {
      $this->load_settings();
    }
    public function get_setting($key) {
      return $this->settings[$key];
    }
    public function load_settings() {
      require_once(ROOT_PATH ."includes/settings.php");
      $this->settings = $settings;
    }
    public function save_settings() {
      // TODO: Save settings to "/include/settings.php".
    }
  }
?>