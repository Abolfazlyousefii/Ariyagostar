<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{
    public $users;
    public $request;

    public function __construct($users, Request $request)
    {
        $this->users   = $users;
        $this->request = $request;
    }

    public function view(): View
    {
        return view('back.exports.users', [
            'users'     => $this->users,
            'request'   => $this->request,
        ]);
    }
}
