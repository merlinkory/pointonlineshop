<?php
namespace App\Services\Logs;

class LogProcessor
{
    public function __invoke(array $record)
    {
        $msg = ($user = auth()->user()) ? "@{$user->username}\n" : '';
        $ip = request()->server('REMOTE_ADDR');
        $record['extra'] = ['request_from' => "{$msg}ip: $ip"];
        return $record;
    }
}
