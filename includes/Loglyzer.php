<?php

namespace Loglyzer;

require_once __DIR__ . '/Hooks/Loader.php';
require_once __DIR__ . '/Logging/LoggerFactory.php';
require_once __DIR__ . '/Logging/LoggerRegistry.php';
require_once __DIR__ . '/Admin/Menu.php';
require_once __DIR__ . '/Helpers/LogContext.php';

use Loglyzer\Admin\Menu;
use Loglyzer\Helpers\LogContext;
use Loglyzer\Hooks\Loader;
use Loglyzer\Logging\LoggerFactory;
use Loglyzer\Logging\LoggerRegistry;

defined('ABSPATH') || exit;

class Loglyzer {

    protected Loader $loader;

    public function __construct() {
        $this->loader = new Loader();
    }

    public function run(): void
    {
        $this->init_logging();
        $this->register_hooks();
    }

    protected function init_logging(): void
    {
        LoggerFactory::init();
    }

    protected function register_hooks(): void
    {
        $this->loader->add_action('admin_menu', [new Menu(), 'register']);
        $this->loader->add_action('wp_die_handler', function(callable $defaultHandler): callable {
            LoggerRegistry::getLogger()->error("wp_die triggered.", LogContext::init());
            return $defaultHandler;
        });
        $this->loader->add_action('template_redirect', function () {
            if (is_404()) {
                $uri = esc_url_raw($_SERVER['REQUEST_URI'] ?? '');
                $referrer = esc_url_raw($_SERVER['HTTP_REFERER'] ?? 'unknown');
                LoggerRegistry::getLogger()->warning("404 Not Found: {$uri} (Referrer: {$referrer})");
            }
        });
        $this->loader->run();
    }
}