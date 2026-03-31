<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Referral;
use App\Rules\CheckJdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;

class UserController extends Controller
{
    public function profile()
    {
        $user        = auth()->user();
        $last_orders = $user->orders()->latest()->take(5)->get();

        return view('front::user.profile', compact('user', 'last_orders'));
    }

    public function update_profile(Request $request)
    {
        $this->validate($request, [
            'first_name'  => 'required|string',
            'last_name'   => 'required|string',
            'mobile'      => 'required|string|regex:/(09)[0-9]{9}/|digits:11|unique:users,username,' . auth()->user()->id,
            'email'       => 'string|email|max:191|unique:users,email,' . auth()->user()->id . '|nullable',
            'birthday'    => ['nullable', 'string', 'max:255', new CheckJdate('Y/m/d')],
            'province_id' => 'required|exists:provinces,id',
            'city_id'     => 'required|exists:cities,id',
            'postal_code' => 'required|numeric|digits:10',
            'address'     => 'required|string|max:300',
        ]);

        $address = auth()->user()->address;

        if (!$address) {
            $address = auth()->user()->address()->create([
                'province_id' => $request->province_id,
                'city_id'     => $request->city_id,
                'postal_code' => $request->postal_code,
                'address'     => $request->address,
            ]);
        } else {
            $address->update([
                'province_id' => $request->province_id,
                'city_id'     => $request->city_id,
                'postal_code' => $request->postal_code,
                'address'     => $request->address,
            ]);
        }

        $birthday = null;

        if ($request->birthday) {
            $birthday = Jalalian::fromFormat('Y/m/d', convertPersianToEnglish($request->birthday))->toCarbon();
        }

        auth()->user()->update([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'username'   => $request->mobile,
            'email'      => $request->email,
            'birthday'   => $birthday
        ]);

        return response('success');
    }

    public function changePassword()
    {
        return view('front::auth.passwords.reset');
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'prev_password' => 'required'
        ]);

        if (!Hash::check($request->prev_password, auth()->user()->password)) {
            throw ValidationException::withMessages(['prev_password' =>  trans('front::messages.controller.wrong-password')]);
        }

        $this->validate($request, [
            'password' => 'required|min:8|confirmed'
        ]);

        $password = Hash::make($request->password);

        auth()->user()->update([
            'password'       => $password,
            'remember_token' => Str::random(60),
        ]);

        DB::table('sessions')->where('user_id', auth()->user()->id)->delete();

        return response('success');
    }

    public function forceChangePassword()
    {
        return view('front::auth.passwords.force-change');
    }

    public function forceUpdatePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:8|confirmed'
        ]);

        auth()->user()->update([
            'password'                 => Hash::make($request->password),
            'remember_token'           => Str::random(60),
            'force_to_password_change' => false,
        ]);

        DB::table('sessions')->where('user_id', auth()->user()->id)->delete();
        Auth::loginUsingId(auth()->user()->id);

        return response('success');
    }

    public function editProfile()
    {
        $user      = auth()->user();
        $provinces = Province::all();

        return view('front::user.edit-profile', compact('user', 'provinces'));
    }

    public function referrals()
    {
        $refrrals = Referral::query()
            ->where(function ($query) {
                $query->where('owner_id', auth()->id())->whereHas('referralDiscount');
            })
            ->orWhere(function ($query) {
                $query->where('user_id', auth()->id())->whereHas('userDiscount');
            })
            ->with('referralDiscount', 'user')
            ->paginate(10);

        return view('front::user.referrals.index', compact('refrrals'));
    }

    public function comments()
    {
        $comments = auth()->user()->comments()->latest()->get();

        return view('front::user.comments', compact('comments'));
    }
}
