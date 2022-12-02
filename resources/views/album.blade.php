<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Foto-upload dinges</title>
    @vite(["resources/js/app.js"])
</head>
<body>
<div class="topBar">
    <p class="title">Foto upload voor Puitenol.nl</p>
    {{-- logout knop --}}
    <a href="#" id="logoutknop" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    {{-- einde logout knop --}}
</div>
<div class="containerDiv">
    <a href="{{ route('uploadhome') }}" class="backButton1"><< terug naar albums</a>
    <h1>{{ $album->name }}</h1>
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    <form action="/upload/albums/uploadMultiple" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="photos[]" id="photos" multiple>
        <input type="hidden" name="albumid" value="{{ $album->id }}">
        <button type="submit" name="submit" class="btn btn-primary">submit</button>
    </form>
    <div id="photoListDiv">
    @foreach ($photos as $photo)
        <div>
            <h1>{{ $photo->filename }}</h1>
            <img src="{{ url('storage/'.$album->foldername.'/'.$photo->filename) }}" alt="">
        </div>
    @endforeach
    </div>
</div>
</body>
</html>