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
        // $path = 'public/'.$request->input('foldername');
        // Storage::makeDirectory($path);
        return $album;
    }

    public function getAlbum($album)
    {
        return view('album', [
            'album' => Album::find($album)
        ]);
    }

    public function deleteAlbum(Request $request)
    {
        $id = $request->input('id');
        return response()->json(['testing' => 'id gevonden. '.$id]);
    }
}
