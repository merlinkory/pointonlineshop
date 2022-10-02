<?php

namespace App\Services\Logs;

use App\Models\Log;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Formatter\FormatterInterface;

class LogHandler extends AbstractProcessingHandler
{
    public function __construct($level = Logger::DEBUG)
    {
        parent::__construct($level);
    }

    protected function write(array $record): void
    {
        $fields = ['level', 'code', 'description', 'file', 'context', 'request_from'];
        $last = Log::latest()->first(); // Берем последний лог
        $formatted = $record['formatted'];
        if ($last && !in_array($last->level, ['notice', 'info', 'debug'])) {
            // Проверяем на повтор
            foreach ($fields as $field) {
                if ($last->$field != ($formatted[$field] ?? null)) {
                    Log::create($formatted); // Создаем новую запись
                    return;
                }
            }
            $last->update(['times' => ++$last->times]); // Повтор - обновляем times
        } else {
            Log::create($formatted);
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultFormatter(): FormatterInterface
    {
        return new LogFormatter();
    }
}
