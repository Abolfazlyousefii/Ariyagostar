<?php

use App\Models\Gateway;
use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class AddGatewayIdToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('gateway_id')->nullable()->after('user_id');
            $table->foreign('gateway_id')->references('id')->on('gateways')->onDelete('set null');
        });

        $this->gatewaysSeed();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign('transactions_gateway_id_foreign');
            $table->dropColumn('gateway_id');
        });
    }

    private function gatewaysSeed()
    {
        $gateways = [
            'behpardakht'    => 'به پرداخت ملت',
            'payir'          => 'pay.ir',
            'zarinpal'       => 'زرین پال',
            'toman'          => 'تومن',
            'payping'        => 'پی پینگ',
            'saman'          => 'سامان',
            'sepehr'         => 'بانک صادرات',
        ];

        foreach ($gateways as $key => $name) {
            Gateway::firstOrCreate(
                [
                    'key'       => $key,
                ],
                [
                    'name'      => $name,
                    'is_active' => option('gateway_' . gateway_key($key) . '_status') == 'on'
                ]
            );
        }

        foreach ($gateways as $key => $name) {

            $gateway = Gateway::where('key', $key)->first();
            $configs = [];

            switch ($gateway->key) {
                case "zarinpal": {
                        $configs['merchantId'] = option('gateway_zarinpal_merchant_id');
                        break;
                    }
                case "payping": {
                        $configs['merchantId'] = option('gateway_payping_merchant_id');
                        break;
                    }
                case "saman": {
                        $configs['merchantId'] = option('gateway_saman_merchantId');
                        break;
                    }
                case "behpardakht": {
                        $configs['terminalId'] = option('gateway_mellat_terminalId');
                        $configs['username'] = option('gateway_mellat_username');
                        $configs['password'] = option('gateway_mellat_password');
                        break;
                    }
                    case "toman": {
                        $configs['shop_slug'] = option('gateway_toman_shop_slug');
                        $configs['auth_code'] = option('gateway_toman_auth_code');
                        break;
                    }
                case "payir": {
                        $configs['merchantId'] = option('gateway_payir_api', 'test');
                        break;
                    }
                case "sepehr": {
                        $configs['terminalId'] = option('gateway_sepehr_terminal_id');
                        break;
                    }
            }

            foreach ($configs as $key => $value) {
                $gateway->configs()->firstOrCreate(
                    [
                        'key'   => $key,
                    ],
                    [
                        'value' => $value
                    ]
                );
            }
        }

        $gateways = Gateway::all();

        foreach ($gateways as $gateway) {
            $key = gateway_key($gateway->key);

            Order::where('gateway', $key)->update([
                'gateway_id' => $gateway->id
            ]);
        }
    }
}
