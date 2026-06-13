<?php

declare(strict_types=1);

use ASAP\Http\Response;

$response = Response::json([
    'ok' => true,
    'source' => 'ASAP REST API',
]);

$response->send();
