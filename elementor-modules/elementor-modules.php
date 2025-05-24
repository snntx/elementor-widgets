<?php
/**
 * Plugin Name: Elementor Modules
 * Description: A collection of custom Elementor modules including Image Lightbox and Tabs
 * Version: 1.0.0
 * Author: Your Name
 * Text Domain: elementor-modules
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Main Elementor Modules Class
 */
final class DOT_Elementor_Modules {

    /**
     * Plugin Version
     */
    const VERSION = '1.0.0';

    /**
     * Minimum Elementor Version
     */
    const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

    /**
     * Minimum PHP Version
     */
    const MINIMUM_PHP_VERSION = '7.0';

    /**
     * Instance
     */
    private static $_instance = null;

    /**
     * Instance
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     */
    public function __construct() {
        add_action('plugins_loaded', [$this, 'init']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories']);
    }

    /**
     * Initialize the plugin
     */
    public function init() {
        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
            return;
        }

        // Check for required Elementor version
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
            return;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            return;
        }

        // Add Plugin actions
        add_action('elementor/widgets/widgets_registered', [$this, 'init_widgets']);
    }

    /**
     * Enqueue scripts and styles
     */
    public function enqueue_scripts() {
        wp_enqueue_style(
            'elementor-modules-widgets',
            plugins_url('assets/css/widgets.css', __FILE__),
            [],
            self::VERSION
        );

        wp_enqueue_script(
            'elementor-modules-widgets',
            plugins_url('assets/js/widgets.js', __FILE__),
            ['jquery'],
            self::VERSION,
            true
        );
    }

    /**
     * Admin notice for missing Elementor
     */
    public function admin_notice_missing_main_plugin() {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'elementor-modules'),
            '<strong>' . esc_html__('Elementor Modules', 'elementor-modules') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'elementor-modules') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin notice for minimum Elementor version
     */
    public function admin_notice_minimum_elementor_version() {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-modules'),
            '<strong>' . esc_html__('Elementor Modules', 'elementor-modules') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'elementor-modules') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin notice for minimum PHP version
     */
    public function admin_notice_minimum_php_version() {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-modules'),
            '<strong>' . esc_html__('Elementor Modules', 'elementor-modules') . '</strong>',
            '<strong>' . esc_html__('PHP', 'elementor-modules') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Add custom widget categories
     */
    public function add_elementor_widget_categories($elements_manager) {
        $elements_manager->add_category(
            'dot-modules',
            [
                'title' => __('DOT Modules', 'elementor-modules'),
                'icon' => 'fa fa-plug',
            ]
        );
    }

    /**
     * Initialize Widgets
     */
    public function init_widgets() {
        // Include Widget files
        require_once(__DIR__ . '/widgets/image-lightbox.php');
        require_once(__DIR__ . '/widgets/tabs.php');

        // Register Widgets
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \DOT_Image_Lightbox_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \DOT_Tabs_Widget());
    }
}

DOT_Elementor_Modules::instance(); 