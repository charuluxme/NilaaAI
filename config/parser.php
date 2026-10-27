<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Parser Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the resume parser driver: 'php' or 'python'
    |
    */

    'driver' => env('PARSER_DRIVER', 'php'),

    /*
    |--------------------------------------------------------------------------
    | Python Parser Endpoint
    |--------------------------------------------------------------------------
    |
    | If using Python driver, specify the microservice endpoint
    |
    */

    'python_endpoint' => env('PARSER_PYTHON_ENDPOINT', 'http://localhost:5000/parse'),

    /*
    |--------------------------------------------------------------------------
    | PDF to Text Binary Path
    |--------------------------------------------------------------------------
    |
    | Path to pdftotext binary (used by spatie/pdf-to-text)
    |
    */

    'pdftotext_path' => env('PDFTOTEXT_PATH', '/usr/bin/pdftotext'),

    /*
    |--------------------------------------------------------------------------
    | File Upload Limits
    |--------------------------------------------------------------------------
    */

    'max_resume_size_mb' => env('MAX_RESUME_SIZE_MB', 5),

];
