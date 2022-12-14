<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Album;
use Illuminate\Support\Facades\Storage;
use Image;


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
        $dir = "public/".Album::find($photo->album_id)->foldername;
        $fileName = $dir."/".$photo->filename;
        $image = Storage::get($fileName);
        $img = Image::make($image);
        $action = $request->input('action');
        if($action == "rotateLeft") {
            $img->rotate(90);
            $file = $img->encode('jpg');
            Storage::put($fileName, $file->__toString());
            $img->destroy();
            return response()->json(["success" => $photo->filename]);

        }
        if($action == "rotateRight") {
            $img->rotate(-90);
            $file = $img->encode('jpg');
            Storage::put($fileName, $file->__toString());
            $img->destroy();
            return response()->json(["success" => $photo->filename]);
        }
        
        return response()->json(["test" => $photo->filename, "action" => $action]);
    }
}
