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
    }

    public function render_page(): void {
        $LoggerFactory = new LoggerFactory();
        $logs = $LoggerFactory->read_and_format_logs();
        echo '<div class="wrap"><h1>Loglyzer Logs!</h1> </div>';
    }
}