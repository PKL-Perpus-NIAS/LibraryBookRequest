<?php

use App\Http\Controllers\BookRequestController;

Route::get('/statistik-permintaan', [BookRequestController::class, 'apiStatistik']);