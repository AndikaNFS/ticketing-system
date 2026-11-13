<?php


use App\Http\Controllers\WhatsappController;
use Illuminate\Support\Facades\Route;

Route::post('/whatsapp/webhook', [WhatsappController::class, 'webhook']);