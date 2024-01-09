<?php
/**
 * Plugin Name: List JS
 * Description: Lists all JavaScript files loaded on each page at the bottom, with sequential numbering and detailed information on source, plugin/theme name, and file size.
 * Version: 1.0
 * Author: Ephraim
 */

// Hook into the footer of the page
add_action('wp_footer', 'list_js_files');

add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
function enqueue_custom_scripts() {
    // Enqueue DataTables library
    wp_enqueue_style('datatables-style', 'https://rocksolidsa.co.za/wp-content/plugins/list-js-files/style.css');
    wp_enqueue_script('jquery');
    wp_enqueue_script('datatables-script', 'https://rocksolidsa.co.za/wp-content/plugins/list-js-files/frontend.js', array('jquery'), null, true);

    // Enqueue your custom JavaScript file
    wp_enqueue_script('custom-datatables-init', plugin_dir_url(__FILE__) . 'datatables-init.js', array('jquery', 'datatables-script'), null, true);

    // Enqueue your custom CSS file
    wp_enqueue_style('custom-style', plugin_dir_url(__FILE__) . 'custom-style.css');
}

function list_js_files() {
    global $wp_scripts; // Access the global scripts variable

    $count = 0;

    echo '<div id="js-files-table" style="margin-top: 20px; padding: 20px; background-color: #f7f7f7; border-top: 1px solid #ccc;">';
    echo '<h4>Loaded JavaScript Files:</h4>';
    echo '<table id="js-files-table" style="width:100%;">';
    echo '<tr><th>#</th><th>Handle</th><th>Path</th><th>Filename</th><th>Source</th><th>Plugin/Theme Name</th><th>File Size (KB)</th></tr>';

    foreach ($wp_scripts->queue as $handle) {
        $count++;
        $script = $wp_scripts->registered[$handle];

        // Get the script source
        $src = $script->src ? $script->src : $script->extra['group'];

        // Strip the domain URL from the src
        $src_path = parse_url($src, PHP_URL_PATH);

        // Get the filename
        $filename = basename($src_path);

        // Determine if the script is from a plugin or theme
        $source = 'Other';
        $name = 'N/A';

        if (strpos($src_path, '/wp-content/plugins/') !== false) {
            $source = 'Plugin';
            $name = get_source_name($src_path, 'plugins');
        } elseif (strpos($src_path, '/wp-content/themes/') !== false) {
            $source = 'Theme';
            $name = get_source_name($src_path, 'themes');
        }

        // Get file size
        $fileSize = get_file_size($src);

        echo '<tr>';
        echo '<td>' . $count . '</td>'; // Sequential Number
        echo '<td>' . esc_html($handle) . '</td>';
        echo '<td>' . esc_html($src_path) . '</td>';
        echo '<td>' . esc_html($filename) . '</td>';
        echo '<td>' . esc_html($source) . '</td>';
        echo '<td>' . esc_html($name) . '</td>';
        echo '<td>' . esc_html($fileSize) . '</td>';
        echo '</tr>';
    }

    echo '</table>';
    echo '</div>';
}

function get_source_name($path, $type) {
    $parts = explode('/', $path);
    $index = array_search($type, $parts);
    return $parts[$index + 1];
}

function get_file_size($url) {
    $size = 0;
    $path = parse_url($url, PHP_URL_PATH);
    $absolute_path = ABSPATH . substr($path, 1); // Assuming WordPress root directory

    if (file_exists($absolute_path)) {
        $size = filesize($absolute_path) / 1024; // Convert bytes to KB
    }

    return round($size, 2); // Round to 2 decimal places
}
?>
