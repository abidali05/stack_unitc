<?php

return [

    'zoom' => [
        'client_id' => env('ZOOM_CLIENT_ID', ''),
        'client_secret' => env('ZOOM_CLIENT_SECRET', ''),
        'redirect_uri' => env('ZOOM_CALLBACK_REDIRECTS', ''),
    ],
];
