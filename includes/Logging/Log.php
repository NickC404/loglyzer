<?php

namespace Loglyzer\Helpers;

class Log {

    public int $error_code;

    public string $error_message;

    public array $context;

    public \DateTime $datetime;

    public function get_error_code(): ?int
    {
        return $this->error_code;
    }

    public function get_error_message(): ?string
    {
        return $this->error_message;
    }

    public function get_datetime(): \DateTime
    {
        return $this->datetime;
    }

    public function get_context(): array
    {
        return $this->context;
    }

    /**
     * @throws \Exception
     */
    public static function from_array(array $log_data): Log {
        $log = new self();
        $log->error_code = $log_data['level'];
        $log->error_message = $log_data['message'];
        $log->context = $log_data['context'];
        $log->datetime = new \DateTime($log_data['datetime']);

        return $log;
    }

    public function to_array(): array {
        return [
            'error_code' => $this->get_error_code(),
            'error_message' => $this->get_error_message(),
            'context' => $this->get_context(),
            'datetime' => $this->get_datetime()
        ];
    }
}