<?php

namespace App\Controller;

class TeamsException extends \Exception
{

    public function __construct(\Throwable $throwable)
    {
        parent::__construct($throwable->getMessage(), $throwable->getCode(), $throwable);
    }

    public function sendAlert($message): string
    {
       return $message ?? 'Error';
    }
}
