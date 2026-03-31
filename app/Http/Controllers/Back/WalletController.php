<?php

namespace App\Http\Controllers\Back;

use App\Events\WalletAmountDecreased;
use App\Events\WalletAmountIncreased;
use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:users.wallet');
    }

    public function show(Wallet $wallet)
    {
        $histories = $wallet->histories()->latest()->paginate(20);

        return view('back.wallets.show', compact('wallet', 'histories'));
    }

    public function create(Wallet $wallet)
    {
        return view('back.wallets.create', compact('wallet'));
    }

    public function store(Wallet $wallet, Request $request)
    {
        $data = $request->validate([
            'type'        => 'required|in:deposit,withdraw',
            'amount'      => 'required|numeric|max:100000000',
            'description' => 'nullable'
        ]);

        $data['source'] = 'admin';
        $data['status'] = 'success';

        if ($data['type'] == 'withdraw') {
            $request->validate([
                'amount' => 'numeric|max:' . $wallet->balance
            ]);
        }

        DB::transaction(function () use ($wallet, $data) {
            $wallet->histories()->create($data);

            if ($data['type'] == 'deposit') {
                $wallet->update([
                    'balance' => $wallet->balance + $data['amount']
                ]);

                event(new WalletAmountIncreased($wallet));
            } else {
                $wallet->update([
                    'balance' => $wallet->balance - $data['amount']
                ]);

                event(new WalletAmountDecreased($wallet));
            }
        });

        toastr()->success('تراکنش با موفقیت ایجاد شد');

        return response('success');
    }

    public function history(WalletHistory $history)
    {
        return view('back.wallets.history', compact('history'));
    }
}
