<?php

use App\Models\Referral;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferralToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('referral_code')->unique()->nullable()->after('email');
            $table->unsignedBigInteger('referral_id')->nullable()->after('referral_code');
            $table->foreign('referral_id')->references('id')->on('users')->onDelete('set null');
        });

        $users = User::select('id')->get();

        foreach ($users as $user) {
            $user->update([
                'referral_code' => Referral::generateCode()
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_referral_code_unique');
            $table->dropColumn('referral_code');
            $table->dropForeign('users_referral_id_foreign');
            $table->dropColumn('referral_id');
        });
    }
}
