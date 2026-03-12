<?php

// Handle CORS preflight immediately before Laravel boots
// This ensures OPTIONS requests always get a valid response
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: https://jelita-bps.vercel.app');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, Accept, X-Requested-With');
    header('Access-Control-Max-Age: 86400');
    http_response_code(204);
    exit;
}

// Bootstrap Laravel
require __DIR__ . '/../public/index.php';
