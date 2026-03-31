<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('user_id', auth()->user()->id)
            ->latest()
            ->paginate(20);

        return view('front::user.tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('front::user.tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject'         => 'required|string',
            'priority'        => 'required|string',
            'message'         => 'required|string',
            'upload_files'    => 'array',
            'upload_files.*'  => 'file|max:204800|mimes:png,jpeg,jpg,zip'
        ]);


        $ticket = Ticket::create([
            'subject'  => $request->subject,
            'priority' => $request->priority,
            'message'  => $request->message,
            'user_id'  => auth()->user()->id
        ]);

        $message = $ticket->messages()->create([
            'user_id' => auth()->user()->id,
            'message' => $request->message
        ]);


        if ($request->upload_files) {

            foreach ($request->upload_files as $file) {
                $date = Carbon::now()->format('Y-m-d');
                $name = $date . '/' . uniqid('form_' . $date . '_', true) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('tickets/', $name);

                $message->files()->create([
                    'file' => '/uploads/tickets/' . $name,
                ]);
            }

        }

        return response('success');
    }

    public function show(Ticket $ticket)
    {
        if ($ticket->user_id != auth()->user()->id) {
            abort(404);
        }

        return view('front::user.tickets.show', compact('ticket'));
    }

    public function update(Ticket $ticket, Request $request)
    {
        if ($ticket->user_id != auth()->user()->id) {
            abort(404);
        }

        $request->validate([
            'message'         => 'required|string',
            'upload_files'    => 'array',
            'upload_files.*'  => 'file|max:204800|mimes:png,jpeg,jpg,zip'
        ]);

        $message = $ticket->messages()->create([
            'user_id' => auth()->user()->id,
            'message' => $request->message
        ]);


        if ($request->upload_files) {

            foreach ($request->upload_files as $file) {
                $date = Carbon::now()->format('Y-m-d');
                $name = $date . '/' . uniqid('form_' . $date . '_', true) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('tickets/', $name);

                $message->files()->create([
                    'file' => '/uploads/tickets/' . $name,
                ]);
            }

        }

        return response('success');
    }
}
