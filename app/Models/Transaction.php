<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = ['id'];

    public function transactionable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        switch ($this->transactionable_type) {
            case Order::class: {
                    $type = 'خرید محصول';
                    break;
                }
            case WalletHistory::class: {
                    $type = 'شارژ کیف پول';
                    break;
                }
        }

        return $type ?? '--';
    }

    public function link()
    {
        switch ($this->transactionable_type) {

            case Order::class: {
                    $link = route('admin.orders.show', ['order' => $this->transactionable]);
                    break;
                }
            case WalletHistory::class: {
                    $link = route('admin.wallets.show', ['wallet' => $this->transactionable->wallet]);
                    break;
                }
        }

        return $link ?? '--';
    }

    public function scopeFilter($query, $request)
    {
        if ($fullname = $request->input('query.fullname')) {
            $query->whereHas('user', function ($q) use ($fullname) {
                $q->WhereRaw("concat(first_name, ' ', last_name) like '%{$fullname}%' ");
            });
        }

        if ($username = $request->input('query.username')) {
            $query->whereHas('user', function ($q) use ($username) {
                $q->Where('username', 'like', "%$username%");
            });
        }

        if ($cardNumber = $request->input('query.cardNumber')) {
            $query->Where('cardNumber', 'like', "%$cardNumber%");
        }

        if ($transId = $request->input('query.transId')) {
            $query->Where('transId', 'like', "%$transId%");
        }

        if ($id = $request->input('query.id')) {
            $query->Where('id', $id);
        }

        $status = $request->input('query.status');

        if ($status !== null && in_array($status, ['0', '1'])) {
            $query->Where('status', $status);
        }

        if ($order_id = $request->input('query.order_id')) {
            $query->whereHasMorph('transactionable', [Order::class], function ($q) use ($order_id) {
                $q->where('id', $order_id);
            });
        }

        if ($request->sort && $request->sort['field'] == 'fullname') {
            $query->join('users', 'transactions.user_id', '=', 'users.id')
                ->orderBy('users.first_name', $request->sort['sort'])
                ->orderBy('users.last_name', $request->sort['sort'])
                ->select('transactions.*');
        } else if ($request->sort && $this->getConnection()->getSchemaBuilder()->hasColumn($this->getTable(), $request->sort['field'])) {
            $query->orderBy($request->sort['field'], $request->sort['sort']);
        }

        return $query;
    }
}
