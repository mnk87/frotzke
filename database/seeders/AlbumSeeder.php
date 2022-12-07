<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('albums')->insert([
            'name' => "album1",
            'foldername' => "album1",
            'yearfolder' => "fotos2023"
        ]);
        if(!in_array('album1', Storage::directories('/public')))
        {
            $path = 'public/album1';
            Storage::makeDirectory($path);
            echo 'folder created.';
        }
    }
}
