<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',

    'cover' => [
        'format' => 'jpg',
        'extension' => '.jpeg',
        'directory' => 'cover/',
        'sizes' => [
            'large' => ['width' => 1024, 'height' => 576, 'quality' => 75],
            'thumb' => ['width' => 320, 'height' => 180, 'quality' => 75],
            'small' => ['width' => 64, 'height' => 36, 'quality' => 85],
            'blur' => ['width' => 16, 'height' => 9, 'quality' => 20],
        ],
    ],
];
