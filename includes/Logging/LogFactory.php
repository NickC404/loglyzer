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

    public const RECORDS_PER_PAGE = 20;

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

        // Paginator Information
        $file->seek(PHP_INT_MAX);
        $max_records = $file->key();
        $start = ($page_number - 1) * self::RECORDS_PER_PAGE;
        $end = min($start + self::RECORDS_PER_PAGE - 1, $max_records - 1);
        $pagination_info = [
            'max_records' => $max_records,
            'start' => $start,
            'end' => $end,
            'max_page_number' => (int) ceil($max_records / self::RECORDS_PER_PAGE),
        ];

        $file->seek($start);
        $lines = [];
        $logs = [];

        while (!$file->eof() && $file->key() <= $end) {
            $lines[] = $file->current();
            $file->next();
        }
        if (empty($lines)) {
            return [
                'logs' => $logs,
                'pagination_info' => $pagination_info
            ];
        }
        foreach ($lines as $line) {
            $decodedLine = json_decode($line, true);
            if (empty($decodedLine)) {
                continue;
            }
            $logs[] = Log::from_array($decodedLine);
        }

        return compact('logs','pagination_info');
    }
}
