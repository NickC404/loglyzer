<?php
namespace Loglyzer\Helpers;

class LogContext {
    public static function init(): array {
        return [
            'uri' => $_SERVER['REQUEST_URI'] ?? '',
            'referrer' => $_SERVER['HTTP_REFERER'] ?? '',
            'user_id' => get_current_user_id(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
        ];
    }
}