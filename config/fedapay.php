<?php

return [
    'public_key' => env('FEDAPAY_PUBLIC_KEY'),
    'secret_key' => env('FEDAPAY_SECRET_KEY'),
    'environment' => env('FEDAPAY_ENVIRONMENT', 'sandbox'),
];
