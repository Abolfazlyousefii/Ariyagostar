<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class NewPasswordController extends Controller
{
    public function show()
    {
        return view('back.auth.change-password');
    }

    public function store(Request $request)
    {
        $request->validate([
            'password' => 'required|string|confirmed|min:8',
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
            'force_to_password_change' => false,
        ]);

        DB::table('sessions')->where('user_id', auth()->user()->id)->delete();
        Auth::loginUsingId(auth()->user()->id);

        return response('success');
    }
}
