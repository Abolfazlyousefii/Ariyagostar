<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Models\Contact;
use App\Events\ContactCreated as EventsContactCreated;
use App\Http\Controllers\Controller;
use App\Notifications\Contact\ContactCreated;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    public function index()
    {
        return view('front::contact');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'    => 'required|string|max:191',
            'mobile'   => 'required|string|max:191',
            'subject' => 'required|string|max:191',
            'captcha' => ['required', 'captcha'],
            'message' => 'required|string|max:2000',
        ]);

        $contact = Contact::create([
            'name'    => $request->name,
            'email'   => $request->mobile,
            'subject' => $request->subject,
            'message' => $request->message,
            'lang'    => app()->getLocale(),
        ]);

        $admins = User::whereIn('level', ['admin', 'creator'])->get();
        Notification::send($admins, new ContactCreated($contact));

        event(new EventsContactCreated($contact));

        return response(['message' => 'success']);
    }
}
