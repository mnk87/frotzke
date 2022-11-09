<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use Illuminate\Support\Facades\Storage;
use App\Models\Album;

class TestController extends Controller
{
    public function getAll()
    {
        return view('welcome', [
            'tests' => Test::all()
        ]);
    }

    public function getFiles()
    {
        return Storage::files('/public');
    }

    public function testAuth(Request $request)
    {
        return 'gelukt';
    }

    public function uploadview()
    {
        return view('upload', ['albums' => Album::all()]);
    }
}
