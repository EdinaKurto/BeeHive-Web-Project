<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../../../../vendor/autoload.php';

use OpenApi\Generator;

// Output as JSON always
header('Content-Type: application/json');

// Start output buffering to suppress any accidental HTML warnings
ob_start();

// Scan annotations
$openapi = Generator::scan([
    __DIR__ . '/doc_setup.php',
    __DIR__ . '/../../../../backend/routes/index.php'
]);

// Clean up any warnings
ob_end_clean();

// Output OpenAPI spec
echo $openapi->toJson();
