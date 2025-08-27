<?php

declare(strict_types=1);

use App\Http\Controllers\LapsController;
use Illuminate\Support\Facades\Route;

Route::get('/laps/grouped', [LapsController::class, 'grouped']);
