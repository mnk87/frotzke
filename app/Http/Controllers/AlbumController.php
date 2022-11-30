<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use Illuminate\Support\Facades\Storage;
use Validator;

class AlbumController extends Controller
{
    public function uploadview()
    {
        return view('upload', ['albums' => Album::all()]);
    }

    public function storeAlbum(Request $request)
    {
        $album = new Album;
        $album->name = $request->input('name');
        $album->foldername = $request->input('foldername');
        $test = false;
        if(empty($request->input('name')) || empty($request->input('foldername'))) {
            return response()->json(["error" => "Er is iets fout gegaan met het aanmaken van een nieuw album. Controleer of je beide velden hebt ingevuld."]);
        }
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

    public function deleteAlbum($album)
    {
        $album = Album::find($album);
        $path = 'public/'.$album->foldername;
        $dirs = Storage::directories('public/');
        if(in_array($path, $dirs)){
            Storage::deleteDirectory($path);
            $album->delete();
            return response()->json(["success" => "map en model verwijderd"]);
        } else {
            $album->delete();
            return response()->json(["error" => "alleen model verwijderd, map niet gevonden."]);
        }
    }

    public function uploadMultiple(Request $request)
    {
        // dd($request->file('photos'));
        $album = Album::find($request->input('albumid'));
        $foldername = $album->foldername;
        
        foreach($request->file('photos') as $file)
        {
            //do something with files
        }
    }
}
