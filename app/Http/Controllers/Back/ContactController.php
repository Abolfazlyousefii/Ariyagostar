<?php

namespace App\Http\Controllers\Back;

use App\Models\Contact;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Contact::class, 'contact');
    }

    public function index()
    {
        $contacts = Contact::latest()->paginate(15);

        return view('back.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        return view('back.contacts.show', compact('contact'))->render();
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return response('success');
    }
}
