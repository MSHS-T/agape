<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function template($form, $type, $year){
        // Check if file exists in app/storage/file folder
        $filename = "{$form}_{$type}_{$year}.xlsx";
        $file_path = storage_path("app/public/formulaires/$filename");
        if (file_exists($file_path))
        {
            // Send Download
            return response()->download($file_path, "Formulaire_".$filename, [
                'Content-Length: '. filesize($file_path)
            ]);
        }
        else
        {
            abort(404);
        }
    }

    public function attachment($application_id, $index){
        $application = \App\Application::findOrFail($application_id);
        $file = $application->files()->where('order', $index)->first();
        if(is_null($file)){
            abort(404);
        }
        return response()->download(base_path($file->filepath), $file->name, [
            'Content-Length: '. filesize(base_path($file->filepath))
        ]);
    }
}
