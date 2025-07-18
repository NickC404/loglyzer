<?php

namespace Loglyzer\Admin;

use Loglyzer\Logging\LoggerFactory;

defined('ABSPATH') || exit;

Class Menu {
    public function register(): void {
        add_menu_page(
            'Loglyzer',
            'Loglyzer',
            'manage_options',
            'loglyzer',
            [$this, 'render_page'],
            'dashicons-visibility',
        );
        add_action('admin_enqueue_scripts', [self::class, 'enqueueAssets']);
    }

    public static function enqueueAssets($hook): void {
        // Only load on your plugin page
        if ($hook !== 'toplevel_page_loglyzer') {
            return;
        }

        wp_enqueue_style(
            'loglyzer-pico',
            plugins_url('../../assets/css/pico.min.css', __FILE__),
            [],
            '1.0'
        );
    }

    public function render_page(): void {
        $LoggerFactory = new LoggerFactory();
        $logs = $LoggerFactory->read_and_format_logs();

        include plugin_dir_path(dirname(dirname(__FILE__))) . 'templates/admin-dashboard.php';
    }
}
