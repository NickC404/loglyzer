<?php

/**
 * Plugin Name: Loglyzer
 * Plugin URI:
 * Description: Monolog logging and visualisation for WordPress.
 * Author: Nick Cotterill
 * Author URI: https://nickcotterill.co.uk
 * Text Domain:
 * License:
 * Version: 1.0.0
 */

if(!defined('ABSPATH')) exit;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/includes/Loglyzer.php';

use Loglyzer\Loglyzer;

function run_loglyzer(): void
{
    $plugin = new Loglyzer();
    $plugin->run();
}
run_loglyzer();
