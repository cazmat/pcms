<?php
class Template {
    private $system;
    private $template_dir;
    private $layout = null;
    private $sections = [];
    private $current_section = null;
    private $data = [];

    public function __construct($system) {
        $this->system = $system;
        $this->template_dir = ROOT_PATH . 'templates/';
    }

    /**
     * Render a template file with data
     */
    public function render($template, $data = []) {
        $template_path = $this->template_dir . $template;

        if (!file_exists($template_path)) {
            throw new Exception("Template not found: {$template}");
        }

        // Store data for use in partials
        $this->data = $data;

        // Extract data array into variables
        extract($data);

        // Make $system and $template available in templates
        $system = $this->system;
        $template = $this;

        // Start output buffering
        ob_start();

        // Parse and include the template
        $parsed_content = $this->parse(file_get_contents($template_path));
        eval('?>' . $parsed_content);

        $content = ob_get_clean();

        // If a layout is set, render it with the content
        if ($this->layout) {
            $layout_path = $this->template_dir . 'layouts/' . $this->layout;
            $this->layout = null; // Reset for next render

            if (!file_exists($layout_path)) {
                throw new Exception("Layout not found: {$layout_path}");
            }

            // Extract data for layout too
            extract($this->data);
            $system = $this->system;
            $template = $this;

            ob_start();
            $parsed_layout = $this->parse(file_get_contents($layout_path));
            eval('?>' . $parsed_layout);
            $content = ob_get_clean();
        }

        return $content;
    }

    /**
     * Include a partial template
     */
    public function partial($partial, $data = []) {
        $partial_path = $this->template_dir . 'partials/' . $partial;

        if (!file_exists($partial_path)) {
            throw new Exception("Partial not found: {$partial}");
        }

        // Merge passed data with stored data (passed data takes priority)
        $merged_data = array_merge($this->data, $data);

        // Extract data array into variables
        extract($merged_data);

        // Make $system and $template available in partials
        $system = $this->system;
        $template = $this;

        // Parse and include the partial
        $parsed_content = $this->parse(file_get_contents($partial_path));
        eval('?>' . $parsed_content);
    }

    /**
     * Parse custom template syntax
     */
    private function parse($content) {
        // Parse @extends directive
        $content = preg_replace_callback('/@extends\([\'"](.+?)[\'"]\)/', function($matches) {
            $this->layout = $matches[1];
            return '';
        }, $content);

        // Parse @section directive
        $content = preg_replace_callback('/@section\([\'"](.+?)[\'"]\)(.*?)@endsection/s', function($matches) {
            $section_name = $matches[1];
            $section_content = trim($matches[2]);
            $this->sections[$section_name] = $section_content;
            return '';
        }, $content);

        // Parse @yield directive
        $content = preg_replace_callback('/@yield\([\'"](.+?)[\'"]\)/', function($matches) {
            $section_name = $matches[1];
            return isset($this->sections[$section_name]) ? $this->sections[$section_name] : '';
        }, $content);

        // Parse @include directive
        $content = preg_replace_callback('/@include\([\'"](.+?)[\'"]\)/', function($matches) {
            return '<?php $template->partial(\'' . $matches[1] . '\'); ?>';
        }, $content);

        // Parse {{ $var }} syntax - escaped output
        $content = preg_replace('/\{\{\s*(.+?)\s*\}\}/', '<?php echo e($1); ?>', $content);

        // Parse {!! $var !!} syntax - raw output (unescaped)
        $content = preg_replace('/\{!!\s*(.+?)\s*!!\}/', '<?php echo $1; ?>', $content);

        return $content;
    }
}
?>
