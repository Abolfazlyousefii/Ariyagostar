<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Ticket::class, 'ticket');
    }

    public function index()
    {
        $tickets = Ticket::latest()->paginate(20);

        return view('back.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        return view('back.tickets.show', compact('ticket'));
    }

    public function create()
    {
        $users = User::where('id', '!=', auth()->user()->id)->get();

        return view('back.tickets.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject'  => 'required|string',
            'priority' => 'required|string',
            'message'  => 'required|string',
            'user_id'  => 'required|exists:users,id'
        ]);

        $ticket = Ticket::create([
            'subject'  => $request->subject,
            'priority' => $request->priority,
            'message'  => $request->message,
            'user_id'  => $request->user_id
        ]);

        $message = $ticket->messages()->create([
            'user_id' => auth()->user()->id,
            'message' => $request->message
        ]);

        if ($request->upload_files) {
            $upload_files = explode(',', $request->upload_files);

            foreach ($upload_files as $upload_file) {

                if (Storage::exists('tmp/' . $upload_file)) {

                    Storage::move('tmp/' . $upload_file, 'tickets/' . $upload_file);

                    $message->files()->create([
                        'file' => '/uploads/tickets/' . $upload_file,
                    ]);
                }
            }
        }

        return response('success');
    }

    public function update(Ticket $ticket, Request $request)
    {
        $request->validate([
            'message'  => 'required|string'
        ]);

        $message = $ticket->messages()->create([
            'user_id' => auth()->user()->id,
            'message' => $request->message
        ]);

        if ($request->upload_files) {
            $upload_files = explode(',', $request->upload_files);

            foreach ($upload_files as $upload_file) {

                if (Storage::exists('tmp/' . $upload_file)) {

                    Storage::move('tmp/' . $upload_file, 'tickets/' . $upload_file);

                    $message->files()->create([
                        'file' => '/uploads/tickets/' . $upload_file,
                    ]);
                }
            }
        }

        return response('success');
    }

    public function destroy(Ticket $ticket)
    {
        foreach ($ticket->messages as $message) {
            foreach ($message->files as $file) {
                Storage::disk('public')->delete($file->file);
                $file->delete();
            }
        }

        $ticket->delete();

        return response('success');
    }

    public function storeFile(Request $request)
    {
        $this->authorize('tickets');

        $request->validate([
            'file' => 'required|file|max:204800|mimes:png,jpeg,jpg,zip'
        ]);

        $date = Carbon::now()->format('Y-m-d');

        $file = $request->file;
        $name = $date . '/' . uniqid('form_' . $date . '_', true) . '.' . $file->getClientOriginalExtension();
        $request->file->storeAs('tmp', $name);

        return response($name);
    }

    public function destoryFile(Request $request)
    {
        $this->authorize('tickets');

        $request->validate([
            'filename' => 'required'
        ]);

        Storage::delete('tmp/' . $request->filename);

        return response('success');
    }
}
