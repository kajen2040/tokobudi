<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => 'b4f53da7a3379302e20663898110ebce', 
            // env('AWS_ACCESS_KEY_ID'),
            'secret' => '077c3f6b5782d0fcd146bcf963e50526ae986e667748ac62a3f63e3d03ed68ec', 
            // env('AWS_SECRET_ACCESS_KEY'),
            'region' => 'auto', 
            // env('AWS_DEFAULT_REGION'),
            'bucket' => 'fls-9f4f813f-77f4-4d47-a42f-1402a75feb3f', 
            // env('AWS_BUCKET'),
            'url' => 'https://fls-9f4f813f-77f4-4d47-a42f-1402a75feb3f.laravel.cloud', 
            // env('AWS_URL'),
            'endpoint' => 'https://367be3a2035528943240074d0096e0cd.r2.cloudflarestorage.com', 
            // env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
