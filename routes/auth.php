<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\LoginWithCodeController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\OneTimeLoginController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware(['guest', 'CheckUserExists'])
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware(['guest', 'CheckUserExists']);

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware(['guest', 'CheckUserExists'])
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware(['guest', 'CheckUserExists']);

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth');

Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/change-password', [NewPasswordController::class, 'show'])
    ->middleware(['auth', 'EnsureForceChange'])
    ->name('change-password');

Route::post('/change-password', [NewPasswordController::class, 'store'])
    ->middleware(['auth', 'EnsureForceChange']);

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware(['guest', 'throttle:10,1'])
    ->name('password.send');

Route::get('/login-with-code', [LoginWithCodeController::class, 'create'])
    ->middleware('guest')
    ->name('login-with-code.request');

Route::post('/login-with-code', [LoginWithCodeController::class, 'store'])
    ->middleware(['guest', 'throttle:10,1'])
    ->name('login-with-code.send');

Route::post('/login-with-code/confirm', [LoginWithCodeController::class, 'confirm'])
    ->middleware(['guest'])
    ->name('login-with-code.confirm');

Route::get('/one-time-login', [OneTimeLoginController::class, 'create'])
    ->middleware(['guest'])
    ->name('one-time-login');

Route::post('/one-time-login', [OneTimeLoginController::class, 'store'])
    ->middleware(['guest']);

Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
    ->middleware('auth')
    ->name('password.confirm');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
    ->middleware('auth');
