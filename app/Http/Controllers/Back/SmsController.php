<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Sms;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function show(Sms $sms)
    {
        $this->authorize('statistics.sms');

        return view('back.statistics.sms.sms-show', compact('sms'));
    }
}
