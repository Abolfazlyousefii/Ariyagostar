<?php

namespace App\Http\Resources\Datatable\Transaction;

use Illuminate\Http\Resources\Json\JsonResource;

class Transaction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'transaction_id'    => $this->id,
            'fullname'          => $this->user ? htmlspecialchars($this->user->fullname) : '-',
            'created_at'        => jdate($this->created_at)->format('%d %B %Y'),
            'amount'            => trans('messages.currency.prefix') . number_format($this->amount) . trans('messages.currency.suffix'),
            'status'            => $this->status,

            'links' => [
                'view'    => route('admin.transactions.show', ['transaction' => $this]),
                'destroy' => route('admin.transactions.destroy', ['transaction' => $this]),
                'user'    => $this->user ? route('admin.users.show', ['user' => $this->user]) : '#',
            ]
        ];
    }
}
