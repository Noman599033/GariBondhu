<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$validator = validator(
    [
        'pickup_at' => '2026-08-11T09:47',
        'return_at' => '2026-08-11T11:47'
    ],
    [
        'pickup_at' => 'required|date',
        'return_at' => 'required|date|after:pickup_at',
    ]
);

if ($validator->fails()) {
    echo "Fails:\n";
    print_r($validator->errors()->toArray());
} else {
    echo "Passes!";
}
