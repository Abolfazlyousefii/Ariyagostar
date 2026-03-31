<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OneTimeCode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OneTimeLoginController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|exists:users,username'
        ]);

        $view = config('front.pages.one-time-login');

        if (!$view || $validator->fails()) {
            abort(404);
        }

        $user = User::where('username', $request->mobile)->first();
        $verify_code = OneTimeCode::where('user_id', $user->id)->latest()->first();

        if (!$verify_code) {
            return redirect()->route('password.request');
        }

        $resend_time = $verify_code->created_at->addSeconds(120)->timestamp;

        return view($view, compact('resend_time', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mobile' => 'required|exists:users,username',
        ]);

        $user = User::where('username', $request->mobile)->first();
        $time = Carbon::now()->subMinutes(15);

        $request->validate([
            'verify_code'     => [
                'required',
                Rule::exists('one_time_codes', 'code')->where(function ($query) use ($user, $time) {
                    $query->where('user_id', $user->id)->where('created_at', '>=', $time);
                }),
            ]
        ], [
            'verify_code.exists' => 'کد وارد شده اشتباه است'
        ]);

        $user->update([
            'force_to_password_change' => true,
        ]);

        Auth::loginUsingId($user->id, true);
        OneTimeCode::where('user_id', $user->id)->delete();

        return response('success');
    }
}
