<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function attachment($application_id, $index){
        $application = \App\Application::findOrFail($application_id);
        $file = $application->files()->where('order', $index)->first();
        if(is_null($file)){
            abort(404);
        }
        return response()->download(public_path('storage/'.$file->filepath), $file->name, [
            'Content-Length: '. filesize(public_path('storage/'.$file->filepath))
        ]);
    }
}
