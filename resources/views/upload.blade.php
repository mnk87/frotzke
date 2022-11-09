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
    <h1 class="uploadTitle">Albums</h1>
    <div class="albumDiv">
        @foreach ($albums as $album)
        <a href="/upload/albums/{{ $album->id }}">
            <div class="albumCard">
                <h3 class="albumTitle">{{ $album->name }}</h3>
            </div>
        </a>
        @endforeach
    </div>
</div>
</body>
</html>