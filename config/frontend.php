<?php

return [
    'url' => env('FRONTEND_URL', 'http://localhost:3000'),
    'email_verify_url' => env('FRONTEND_EMAIL_VERIFY_URL', '/email/verify?queryURL='),
    'reset_password_url' => env('FRONTEND_RESET_PASSWORD_URL', '/password/reset'),
];
