<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],


        'gcs' => [
            'driver' => 'gcs',
            'project_id' => env('FB_PROJECT_ID'),
            'key_file' => [
                'type' => env('FB_TYPE'),
                'private_key_id' => env('FB_PRIVATE_KEY_ID'),
                'private_key' => env('FB_PRIVATE_KEY'),
                'client_email' => env('FB_CLIENT_EMAIL'),
                'client_id' => env('FB_CLIENT_ID'),
                'auth_uri' => env('FB_AUTH_URI'),
                'token_uri' => env('FB_TOKEN_URI'),
                'auth_provider_x509_cert_url' => env('FB_AUTH_PROVIDER_X509_CERT_URL'),
                'client_x509_cert_url' => env('FB_CLIENT_X509_CERT_URL'),
            ],
            'bucket' => env('FB_PROJECT_ID') . 'appspot.com',
            'path_prefix' => env('GOOGLE_CLOUD_STORAGE_PATH_PREFIX', '/'),
            'storage_api_uri' => 'https://storage.googleapis.com/' . env('FB_PROJECT_ID') . '.appspot.com/',
            'visibility' => 'public',
        ],
    ],
];
