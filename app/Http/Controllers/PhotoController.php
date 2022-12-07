<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function rotateImg(Request $request)
    {
        //doe bewerking
        return response()->json(['success' => 'foto draaien gelukt']);
    }
}
