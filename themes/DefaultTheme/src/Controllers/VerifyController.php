<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OneTimeCode;
use App\Notifications\Sms\VerifyCodeSent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;

class VerifyController extends Controller
{
    public function showVerify()
    {
        $this->sendCode();
        $verify_code = OneTimeCode::where('user_id', auth()->user()->id)->latest()->first();
        $resend_time = $verify_code->created_at->addSeconds(120)->timestamp;

        return view('front::auth.verify', compact('resend_time'));
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'verify_code' => 'required'
        ]);

        $verify_code = $request->verify_code;
        $expire_time = Carbon::now()->subSeconds(10 * 60);

        $last_sent_code = OneTimeCode::where('user_id', auth()->user()->id)->where('created_at', '>=', $expire_time)->latest()->first();

        if ($last_sent_code && $last_sent_code->code == $verify_code) {
            auth()->user()->update([
                'verified_at' => Carbon::now()
            ]);

            OneTimeCode::where('user_id', auth()->user()->id)->delete();

            return response('success');
        }

        throw ValidationException::withMessages(['verify_code' =>  trans('front::messages.controller.verification-incorrect') ]);
    }

    public function showChangeUsername()
    {
        return view('front::auth.change-username');
    }

    public function changeUsername(Request $request)
    {
        $this->validate($request, [
            'mobile'  => 'required|string|regex:/(09)[0-9]{9}/|digits:11|unique:users,username,' . auth()->user()->id,
        ]);

        if (auth()->user()->username != $request->mobile) {
            auth()->user()->update([
                'username' => $request->mobile
            ]);

            // send sms notification to user
            Notification::send(auth()->user(), new VerifyCodeSent(auth()->user()));
        }

        return response('success');
    }

    private function sendCode()
    {
        $verify_code = OneTimeCode::where('user_id', auth()->user()->id)->latest()->first();

        if ($verify_code) {
            $now = Carbon::now();
            $time = $verify_code->created_at;

            if ($time->diffInSeconds($now) < 120) {
                return;
            }
        }

        // send sms notification to user
        Notification::send(auth()->user(), new VerifyCodeSent(auth()->user()));
    }
}
