<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Login::class => [
            'App\Listeners\UserLogin\GetCart'
        ],

        Registered::class => [
            'App\Listeners\User\Registered',
            'App\Listeners\User\AddGiftCredit',
            'App\Listeners\User\CreateReferralDiscounts',
        ],

        'App\Events\OrderCreated' => [
            'App\Listeners\OrderCreated\SaveAddress',
            'App\Listeners\OrderCreated\ChangePrices',
        ],

        'App\Events\OrderPaid' => [
            'App\Listeners\OrderPaid',
        ],

        'App\Events\WalletAmountIncreased' => [
            'App\Listeners\Wallet\SendWalletIncreasedSms',
        ],

        'App\Events\WalletAmountDecreased' => [
            'App\Listeners\Wallet\SendWalletDecreasedSms',
        ],

        'App\Events\ProductPricesChanged' => [
            'App\Listeners\Product\CreatePricesChange',
        ],

        'App\Events\ContactCreated' => []
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
