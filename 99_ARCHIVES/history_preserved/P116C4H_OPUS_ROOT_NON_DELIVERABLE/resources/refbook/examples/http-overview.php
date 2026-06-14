<?php

declare(strict_types=1);

use Opus\Http\Request;

$request = new Request('/api/refbook/health', 'GET');
echo $request->method . ' ' . $request->path . PHP_EOL;
