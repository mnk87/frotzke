<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;

class PhotoController extends Controller
{
    public function rotateImg(Request $request)
    {
        //doe bewerking
        return response()->json(['success' => 'foto draaien gelukt']);
    }

    public function editImage(Request $request)
    {
        $photo = Photo::find($request->input('photoid'));
        if($photo == null) {
            return response()->json(["error" => "photo not found"]);
        }
        $action = $request->input('action');
        if($action == "rotateLeft") {
            return response()->json(["test" => $photo->filename]);
        }
        if($action == "rotateRight") {
            return response()->json(["test" => $photo->filename]);
        }
        
        return response()->json(["test" => $photo->filename, "action" => $action]);
    }
}
