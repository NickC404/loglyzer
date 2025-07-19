<?php

namespace Loglyzer\Admin;

use Loglyzer\Logging\LogFactory;

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
        wp_enqueue_script(
            'loglyzer-chartjs',
            plugins_url('../../assets/js/chart.umd.min.js', __FILE__),
            [],
            '4.5.0',
            true
        );
    }

    public function render_page(): void {
        $LoggerFactory = new LogFactory();
        $logs = $LoggerFactory->read_and_format_logs();

        include plugin_dir_path(dirname(dirname(__FILE__))) . 'templates/admin-dashboard.php';
    }
}
