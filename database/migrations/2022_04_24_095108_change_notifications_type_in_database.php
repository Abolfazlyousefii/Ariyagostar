<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeNotificationsTypeInDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('notifications')->where('type', 'App\Notifications\ContactCreated')->update(['type' => 'ContactCreated']);
        DB::table('notifications')->where('type', 'App\Notifications\Contact\ContactCreated')->update(['type' => 'ContactCreated']);
        DB::table('notifications')->where('type', 'App\Notifications\UserRegistered')->update(['type' => 'UserRegistered']);
        DB::table('notifications')->where('type', 'App\Notifications\User\UserRegistered')->update(['type' => 'UserRegistered']);
        DB::table('notifications')->where('type', 'App\Notifications\UserCreated')->update(['type' => 'UserCreated']);
        DB::table('notifications')->where('type', 'App\Notifications\User\UserCreated')->update(['type' => 'UserCreated']);
        DB::table('notifications')->where('type', 'App\Notifications\OrderPaid')->update(['type' => 'OrderPaid']);
        DB::table('notifications')->where('type', 'App\Notifications\Order\OrderPaid')->update(['type' => 'OrderPaid']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('notifications')->where('type', 'ContactCreated')->update(['type' => 'App\Notifications\ContactCreated']);
        DB::table('notifications')->where('type', 'UserRegistered')->update(['type' => 'App\Notifications\UserRegistered']);
        DB::table('notifications')->where('type', 'UserCreated')->update(['type' => 'App\Notifications\UserCreated']);
        DB::table('notifications')->where('type', 'OrderPaid')->update(['type' => 'App\Notifications\OrderPaid']);
    }
}
