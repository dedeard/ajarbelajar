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

    'avatar' => [
        'size' => 150,
        'format' => 'jpg',
        'extension' => 'jpeg',
        'quality' => 80,
        'dir' => 'avatar/'
    ],

    'hero' => [
        'format' => 'jpg',
        'extension' => '.jpeg',
        'dir' => 'hero/',
        'sizes' => [
            'large' => [ 'width' => 1024, 'height' => 576, 'quality' => 75 ],
            'thumb' => [ 'width' => 320, 'height' => 180, 'quality' => 75 ],
            'small' => [ 'width' => 64, 'height' => 36, 'quality' => 85 ],
        ]
    ]
];
