<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\OccupantController;

Route::prefix('v1')->group(function () {
    Route::apiResource('occupants', OccupantController::class);
});

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\RepositoryServiceProvider::class,
];
