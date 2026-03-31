<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Events\OrderPaid;
use App\Events\WalletAmountIncreased;
use App\Http\Controllers\Controller;
use App\Models\Gateway;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\WalletHistory;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Shetabit\Payment\Facade\Payment;
use Shetabit\Multipay\Invoice;
use App\Notifications\Order\OrderPaid as NotificationsOrderPaid;

class WalletController extends Controller
{
    public function index()
    {
        $wallet    = auth()->user()->getWallet();
        $histories = $wallet->histories()->latest()->paginate(20);

        return view('front::user.wallet.index', compact('wallet', 'histories'));
    }

    public function show(WalletHistory $wallet)
    {
        return view('front::user.wallet.show')->with('history', $wallet);
    }

    public function create()
    {
        $gateways = Gateway::active()->get();

        return view('front::user.wallet.create', compact('gateways'));
    }

    public function store(Request $request)
    {
        $gateways = Gateway::active()->pluck('key')->toArray();

        $request->validate([
            'amount'      => 'required|numeric|max:500000000|min:1000',
            'gateway'     => 'required|in:' . implode(',', $gateways),
        ]);

        $gateway = $request->gateway;
        $amount  = intval($request->amount);
        $wallet  = auth()->user()->getWallet();

        $history = $wallet->histories()->create([
            'type'        => 'deposit',
            'amount'      => $amount,
            'description' =>  trans('front::messages.controller.wallet-recharge'),
            'source'      => 'user',
            'status'      => 'fail'
        ]);

        try {

            $gateway_configs = get_gateway_configs($gateway);

            return Payment::via($gateway)->config($gateway_configs)->callbackUrl(route('front.wallet.verify', ['gateway' => $gateway]))->purchase(
                (new Invoice)->amount($amount),
                function ($driver, $transactionId) use ($history, $gateway, $amount) {
                    DB::table('transactions')->insert([
                        'status'               => false,
                        'amount'               => $amount,
                        'factorNumber'         => $history->id,
                        'mobile'               => auth()->user()->username,
                        'message'              => trans('front::messages.controller.created-for-gateway') . $gateway,
                        'transID'              => $transactionId,
                        'token'                => $transactionId,
                        'user_id'              => auth()->user()->id,
                        'transactionable_type' => WalletHistory::class,
                        'transactionable_id'   => $history->id,
                        'gateway_id'           => Gateway::where('key', $gateway)->first()->id,
                        "created_at"           => Carbon::now(),
                        "updated_at"           => Carbon::now(),
                    ]);

                    session()->put('transactionId', $transactionId);
                    session()->put('amount', $amount);
                }
            )->pay()->render();
        } catch (Exception $e) {
            return redirect()->route('front.wallet.index', ['history' => $history])->with('transaction-error', $e->getMessage());
        }
    }

    public function verify($gateway)
    {
        $transactionId = session()->get('transactionId');
        $amount        = session()->get('amount');

        $transaction = Transaction::where('status', false)->where('transID', $transactionId)->firstOrFail();

        $history = $transaction->transactionable;

        $gateway_configs = get_gateway_configs($gateway);

        try {
            $receipt = Payment::via($gateway)->config($gateway_configs);

            if ($amount) {
                $receipt = $receipt->amount(intval($amount));
            }

            $receipt = $receipt->transactionId($transactionId)->verify();

            DB::table('transactions')->where('transID', $transactionId)->update([
                'status'               => 1,
                'traceNumber'          => $receipt->getReferenceId(),
                'message'              => $transaction->message . '<br>' . trans('front::messages.controller.successful-gateway') . $gateway,
                'updated_at'           => Carbon::now(),
            ]);

            $history->update([
                'status' => 'success',
            ]);

            event(new WalletAmountIncreased($history->wallet));

            $history->wallet->refereshBalance();

            if ($history->order) {

                if ($history->shipping_cost) {
                    $result = $history->order->payShippingCostUsingWallet();

                    if ($result) {
                        $history->order->update([
                            'reserve' => false,
                            'price'   => $history->order->price + $history->order->shipping_cost
                        ]);

                        $admins = User::whereIn('level', ['admin', 'creator'])->get();
                        Notification::send($admins, new NotificationsOrderPaid($history->order));

                        return redirect()->route('front.orders.show', ['order' => $history->order])->with('message', 'ok');
                    }
                }

                $result = $history->order->payUsingWallet();

                if ($result) {
                    $history->order->update([
                        'status' => 'paid',
                    ]);

                    event(new OrderPaid($history->order));

                    return redirect()->route('front.orders.show', ['order' => $history->order])->with('message', 'ok');
                }
            }

            return redirect()->route('front.wallet.index', ['history' => $history])->with('message', 'ok');
        } catch (\Exception $exception) {

            DB::table('transactions')->where('transID', $transactionId)->update([
                'message'              => $transaction->message . '<br>' . $exception->getMessage(),
                "updated_at"           => Carbon::now(),
            ]);

            if ($history->order) {
                return redirect()->route('front.orders.show', ['order' => $history->order])
                    ->with('transaction-error', $exception->getMessage())
                    ->with('order_id', $history->order->id);
            }

            return redirect()->route('front.wallet.index', ['history' => $history])->with('transaction-error', $exception->getMessage());
        }
    }
}
