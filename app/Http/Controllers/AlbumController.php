<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;
use Validator;
use Image;

class AlbumController extends Controller
{

    private $resizeHeight = 480;
    // TODO: test veranderen in httpdocs
    private $ftpfolder = "test";

    public function uploadview()
    {
        return view('upload', ['albums' => Album::all()]);
    }

    public function storeAlbum(Request $request)
    {
        $foldername = $request->input('foldername');
        if($foldername == "preview"){
            return response()->json(["error" => "verboden mapnaam: preview"]);
        }
        // TODO: Add validation for foldername
        $album = new Album;
        $album->name = $request->input('name');
        $album->foldername = $foldername;
        $album->yearfolder = $request->input('yearfolder');
        // TODO: resize image
        $file = $request->file('bgimg');
        $name = "bgimg".".".$file->getClientOriginalExtension();
        $album->bgimg = $name;
        // return response()->json(["test" => $name]);
        $path = 'public/'.$request->input('foldername');
        Storage::makeDirectory($path);
        $storedFile = $file->storeAs($path, $name);
        if(empty($request->input('name')) || empty($request->input('foldername')) || empty($request->input('yearfolder')) || empty($request->file('bgimg'))) {
            return response()->json(["error" => "Er is iets fout gegaan met het aanmaken van een nieuw album. Controleer of je alle velden hebt ingevuld."]);
        }
        if(!$album->save()){
            return response()->json(["error" => "is nie goed gegaan"]);
        }
        return response()->json(["success" => $album]);
    }

    public function getAlbum($album)
    {
        return view('album', [
            'album' => Album::find($album),
            'photos' => Photo::where('album_id', $album)->get()
        ]);
    }

    public function deleteAlbum($album)
    {
        $album = Album::find($album);
        $album->photos()->delete();
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
        $photos = $request->file('photos');
        foreach($photos as $file)
        {
            $img = Image::make($file);
            if($img->height() > $this->resizeHeight)
            {
                $img->resize(null, $this->resizeHeight, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            $name = trim(strrev(stristr(strrev($file->getClientOriginalName()), ".")), ".")."--".hash("crc32", microtime()).".jpg";
            $encoded = $img->encode('jpg');
            $fileName = "public/".$foldername."/".$name;
            Storage::put($fileName, $encoded->__toString());
            $img->destroy();
            $photo = new Photo;
            $photo->filename = $name;
            $photo->album_id = $album->id;
            $photo->save();
        }
        $oeveel = count($photos);
        $fotos = $oeveel > 1 ? "foto's" : "foto";
        return back()->with('status', $oeveel.' '.$fotos.' met succes geüpload.');
    }

    public function previewUpload($album)
    {
        $albumObj = Album::find($album);
        
        $contents = Storage::disk('ftp')->get($this->ftpfolder."/".$albumObj->yearfolder.'/'.$albumObj->yearfolder.'.html');
        Storage::put('public/preview/'.$albumObj->yearfolder.'.html', $contents);
        $htmlcontents = Storage::get('public/preview/'.$albumObj->yearfolder.'.html');
        $pageLinkString = '        <a href="'.$albumObj->foldername.'.html" class="btn btn-sm" target="_blank" >                                                       <p class="tekst1">'.$albumObj->name.'</p></a>';

        return view('preview', [
            'album' => $albumObj,
            'photos' => Photo::where('album_id', $album)->get(),
            'htmlcontents' => $htmlcontents,
            'newPageLink' => $pageLinkString
        ]);
    }

    public function uploadAlbum(Request $request) {
        $albumObj = Album::find($request->input('album'));
        $photoObjs = $albumObj->photos;
        
        $taVal = $request->input('taVal');
        Storage::disk('ftp')->put($this->ftpfolder."/".$albumObj->yearfolder.'/'.$albumObj->yearfolder.'.html', $taVal);
        // aanmaken van fotopagina
        $headpart = '<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name=description author="nico en michiel van ginhoven">
         
    <link href="../css-files/algemeen_resp.css" rel="stylesheet">
    <link href="../css-files/bscss.css" rel="stylesheet">
         
    <script src="../js-files/bsjs.js" defer></script>
    <script src="../js-files/showstuff.js" defer></script>
    <script src="../js-files/maxscherm.js" defer></script>
          
    <title>'.$albumObj->name.'</title>        
</head>';
        $fileurl = 'public/preview/'.$albumObj->foldername.'.html';
        Storage::put('public/preview/'.$albumObj->foldername.'.html', $headpart);
        $bodybg = '<body style="background-image: url(\''.$albumObj->foldername.'/'.'bgimg.jpg'.'\')" >';
        Storage::append($fileurl, $bodybg);
        $tussenstukje = '    <div class="container">
        <div class="plaat">';
        Storage::append($fileurl, $tussenstukje);
        $photoAmount = count($photoObjs);
        for($i = 0; $i < $photoAmount; $i++){
            $imgString = '            <img src="'.$albumObj->foldername.'/'.$photoObjs[$i]->filename.'">';
            Storage::append($fileurl, $imgString);
        }
        $eindstuk = '            <br><br><br>
            <button onclick="self.close()">sluiten</button>
            <br><br><br>         
        </div>
    </div>
</body>
</html>';
        Storage::append($fileurl, $eindstuk);
        // klaar met html, uploaden via ftp
        $htmlcontents = Storage::get($fileurl);
        Storage::disk('ftp')->put($this->ftpfolder."/".$albumObj->yearfolder."/".$albumObj->foldername.".html", $htmlcontents);
        $photoFolder = "public/".$albumObj->foldername;
        
        // Storage::put('public/preview/'.$albumObj->yearfolder.'.html', $taVal);
        Storage::disk('ftp')->makeDirectory($this->ftpfolder."/".$albumObj->yearfolder."/".$albumObj->foldername."/", 0777, true, true);
        $dir = "public/".Album::find($photoObjs[0]->album_id)->foldername;
        for($i = 0; $i < $photoAmount; $i++) {
            $filename = $dir."/".$photoObjs[$i]->filename;
            $image = Storage::get($filename);
            Storage::disk('ftp')->put($this->ftpfolder."/".$albumObj->yearfolder."/".$albumObj->foldername."/".$photoObjs[$i]->filename, $image);
        }
        return response()->json(["success" => "gelukt!"]); 
    }
}
