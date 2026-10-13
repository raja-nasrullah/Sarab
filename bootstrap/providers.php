<?php

use App\Providers\AppServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\AuthServiceProvider::class,
    App\Providers\BroadcastServiceProvider::class,  // ← ADD THIS LINE
    Laravel\Passport\PassportServiceProvider::class,
];