<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\App;

$model = App::make('App\\Models\\CommuniqueAttachment');

$reflection = new ReflectionClass($model);
$methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

$methodNames = [];
foreach ($methods as $method) {
    if (!$method->isStatic() && $method->class === 'App\\Models\\CommuniqueAttachment') {
        $methodNames[] = $method->name;
    }
}

print_r($methodNames);
