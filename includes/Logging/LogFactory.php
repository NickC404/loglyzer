<?php

namespace Loglyzer\Logging;

use Cassandra\Date;
use DateTime;
use Loglyzer\Helpers\Log;
use Monolog\Formatter\JsonFormatter;
use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;
use SplFileObject;

require_once __DIR__ . '/Log.php';

defined('ABSPATH') || exit;

class LogFactory {

    public const RECORDS_PER_PAGE = 2;

    public static function init(): void
    {
        $logger = new MonologLogger('loglyzer');
        $handler = new StreamHandler(WP_CONTENT_DIR . '/logs/loglyzer.log', MonologLogger::DEBUG);
        $formatter = new JsonFormatter();
        $handler->setFormatter($formatter);
        $logger->pushHandler($handler);

        LoggerRegistry::setLogger($logger);
    }

    /**
     * @throws \Exception
     */
    public function read_and_format_logs(int $page_number = 1): array
    {
        $file = new SplFileObject(WP_CONTENT_DIR . '/logs/loglyzer.log');
        $start = ($page_number - 1) * self::RECORDS_PER_PAGE;
        $end = $start + self::RECORDS_PER_PAGE - 1;
        $file->seek($start);
        $lines = [];
        $logEntries = [];

        while (!$file->eof() && $file->key() <= $end) {
            $lines[] = $file->current();
            $file->next();
        }

        if (empty($lines)) {
            return [];
        }
        foreach ($lines as $line) {
            $decodedLine = json_decode($line, true);
            if (empty($decodedLine)) {
                continue;
            }
            $logEntries[] = Log::from_array($decodedLine);
        }

        return $logEntries;
    }
}
