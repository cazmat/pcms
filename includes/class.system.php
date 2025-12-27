<?php
  class System {
    private $settings;
    function __construct() {
      $this->load_settings();
    }
    public function get_setting($key) {
      return $this->settings[$key];
    }
    public function get_all_settings() {
      return $this->settings;
    }
    public function get_default_settings() {
      return [
        "admin_email" => "admin@example.com",
        "base_url" => "http://localhost",
        "blog_ppp" => 10,
        "date_format" => "F j, Y",
        "maintenance" => false,
        "pretty_url" => true,
        "site_name" => "My Blog",
        "timezone" => "UTC"
      ];
    }
    public function set_setting($key, $value) {
      $this->settings[$key] = $value;
    }
    public function load_settings() {
      require_once(ROOT_PATH ."includes/settings.php");
      $this->settings = $settings;
    }
    public function save_settings() {
      $settingsFile = ROOT_PATH . "includes/settings.php";
      $content = "<?php\n";
      $content .= "  \$settings = [\n";
      foreach ($this->settings as $key => $value) {
        $content .= "    \"$key\" => ";
        if (is_bool($value)) {
          $content .= $value ? 'true' : 'false';
        } elseif (is_numeric($value)) {
          $content .= $value;
        } else {
          $content .= '"' . addslashes($value) . '"';
        }
        $content .= ",\n";
      }
      $content .= "  ];\n";

      return file_put_contents($settingsFile, $content) !== false;
    }
  }
?>