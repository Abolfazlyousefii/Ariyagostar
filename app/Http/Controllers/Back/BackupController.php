<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Jobs\CreateBackup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
    {
        $this->authorize('backups.index');

        $backups = Storage::disk('backup')->allFiles(config('backup.backup.name'));

        foreach ($backups as $key => $backup) {
            $backups[$key] = [];
            $backups[$key]['date'] =  Storage::disk('backup')->lastModified($backup);
            $backups[$key]['name'] =  substr($backup, strrpos($backup, '/') + 1);
            $backups[$key]['size'] =  number_format(Storage::disk('backup')->size($backup) / 1048576, 2) . ' mb';
        }

        $backups = collect($backups);

        return view('back.backups.index', compact('backups'));
    }

    public function create()
    {
        $this->authorize('backups.create');

        CreateBackup::dispatchAfterResponse();

        return response('success');
    }

    public function download($backup)
    {
        $this->authorize('backups.download');

        $filename = config('backup.backup.name') . '/' . $backup;

        if (!Storage::disk('backup')->exists($filename)) {
            abort(404);
        }

        return Storage::disk('backup')->download($filename);
    }

    public function destroy($backup)
    {
        $this->authorize('backups.delete');

        $filename = config('backup.backup.name') . '/' . $backup;

        if (!Storage::disk('backup')->exists($filename)) {
            abort(404);
        }

        Storage::disk('backup')->delete($filename);
        return response('success');
    }
}
