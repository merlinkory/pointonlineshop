<?php

namespace App\Services\Logs;

use Monolog\Formatter\NormalizerFormatter;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class LogFormatter extends NormalizerFormatter
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function format(array $record)
    {
        $rec = parent::format($record);
        return $this->getDocument($rec);
    }
    /**
     * Convert a log message into an MariaDB Log entity
     * @param array $record
     * @return array
     */
    protected function getDocument(array $record)
    {
        if (isset($record['extra'])) {
            $fills = $record['extra'];
        }

        $fills['level'] = Str::lower($record['level_name']);
        $fills['description'] = Str::limit($record['message'], 5000);
        $context = $record['context'];
        if (!empty($context)) {
            if (!empty($context['exception'])) {
                $exception = $context['exception'];
                $fills['file'] = isset($exception['file']) ? $exception['file'] : null;
                $fills['code'] = isset($exception['code']) ? $exception['code'] : null;
                $fills['trace'] = isset($exception['trace']) ? $exception['trace'] : null;
            } else {
                $fills['context'] = $context;
            }
        }

        if (empty($fills['file'])) {
            $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            $fills['file'] = $trace[8]['file'] . ":" . $trace[8]['line'];
            if ($fills['level'] === 'error') {
                $fills['trace'] = array_map(function ($item) {
                    return $item['file'] . ':' . $item['line'];
                }, array_slice($trace, 8));
            }
        }

        $fills['created_at'] = new Carbon($record['datetime']);

        return $fills;
    }
}
