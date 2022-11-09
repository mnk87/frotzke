<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function storeAlbum(Request $request)
    {
        $album = new Album;
        $album->name = $request->input('name');
        $album->foldername = $request->input('foldername');
        if(!$album->save()){
            return response()->json(["error" => "is nie goed gegaan"]);
        }
        $path = 'public/'.$request->input('foldername');
        Storage::makeDirectory($path);
        return $album;
    }

    public function getAlbum($album)
    {
        return view('album', [
            'album' => Album::find($album)
        ]);
    }
}
