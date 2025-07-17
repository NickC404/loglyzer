<?php

namespace Loglyzer\Logging;

use Monolog\Logger;

defined('ABSPATH') || exit;

class LoggerRegistry {
    private static ?Logger $logger = null;

    public static function getLogger(): Logger {
        return self::$logger;
    }

    public static function setLogger(Logger $logger): void {
        self::$logger = $logger;
    }
}