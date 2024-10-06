<?php


namespace App\Library\Services\Admin;


use Illuminate\Support\Facades\Log;
use Exception;

class BaseService
{
    public string $message = '';
    public mixed $data = null;

    protected function log(mixed $exception)
    {
        Log::error($exception);
    }

    protected function handleSuccess(string $message, mixed $data = null): bool
    {
        $this->message = $message;
        $this->data = $data;
        return true;
    }

    protected function handleException(Exception $exception): bool
    {
        $this->log($exception);
        if(get_class($exception) == 'App\Exceptions\CustomException')
            $this->message = $exception->getMessage();
        else
            $this->message = 'Operation failed';
        return false;
    }

}
