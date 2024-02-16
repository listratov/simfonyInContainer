<?php

use App\Kernel;

try {

    require_once dirname(__DIR__).'/vendor/autoload_runtime.php';
}catch (Throwable $e){
    echo $e->getMessage();
}

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
