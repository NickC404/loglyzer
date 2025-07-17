<?php

namespace Loglyzer\Logging;

use Monolog\Formatter\JsonFormatter;
use Monolog\Logger;
use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

defined('ABSPATH') || exit;

class LoggerFactory {
    public static function init(): void
    {
        $logger = new MonologLogger('loglyzer');
        $handler = new StreamHandler(WP_CONTENT_DIR . '/logs/loglyzer.log', MonologLogger::DEBUG);
        $formatter = new JsonFormatter();
        $handler->setFormatter($formatter);
        $logger->pushHandler($handler);

        LoggerRegistry::setLogger($logger);
    }

    public function read_and_format_logs(): array
    {
        $lines = file(WP_CONTENT_DIR . '/logs/loglyzer.log', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $logEntries = [];

        if (empty($lines)) {
            return [];
        }
        foreach ($lines as $line) {
            $decodedLine = json_decode($line, true);
            if (empty($decodedLine)) {
                continue;
            }
            $logEntries[$decodedLine['level']] = [
                'dateTime' => $decodedLine['datetime'],
                'context' => $decodedLine['context']
            ];
        }

        return $logEntries;
    }
}
