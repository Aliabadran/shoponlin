<?php

return [
    App\Providers\AppServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
    App\Providers\EventServiceProvider::class,
    ConsoleTVs\Charts\ChartsServiceProvider::class,  // Add this line
    RealRashid\SweetAlert\SweetAlertServiceProvider::class,
    Mckenziearts\Notify\LaravelNotifyServiceProvider::class
];
