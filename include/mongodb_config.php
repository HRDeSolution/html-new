<?php
/**
 * MongoDB Configuration for legacy site, aligned with html-solution.
 */

@include_once(__DIR__ . '/load_env.php');

return [
    'connection_string' => env('MONGODB_CONNECTION_STRING', ''),
    'database' => env('MONGODB_DATABASE', 'test'),
    'host' => env('MONGODB_HOST', '127.0.0.1'),
    'port' => (int)env('MONGODB_PORT', 27017),
    'username' => env('MONGODB_USERNAME', ''),
    'password' => env('MONGODB_PASSWORD', ''),
    'options' => [
        'connectTimeoutMS' => (int)env('MONGODB_CONNECT_TIMEOUT_MS', 5000),
        'serverSelectionTimeoutMS' => (int)env('MONGODB_SERVER_SELECTION_TIMEOUT_MS', 5000),
    ],
    'collections' => [
        'meetings' => env('MONGODB_COLLECTION_MEETINGS', 'meetings'),
        'participants' => env('MONGODB_COLLECTION_PARTICIPANTS', 'participants'),
        'members' => env('MONGODB_COLLECTION_MEMBERS', 'members'),
    ],
];

