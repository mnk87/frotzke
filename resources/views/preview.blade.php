<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Foto-upload dinges</title>
    <script src="https://cdn.jsdelivr.net/npm/ace-builds@1.14.0/src-noconflict/ace.min.js" defer></script>
    @vite(["resources/js/app.js"])
</head>
<body>
    <script>
        let album = @json($album);
        let photos = @json($photos);
        const folder = "{{ url('storage/'.$album->foldername) }}";
    </script>
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
    <h1 class="bigTitle">Album: {{ $album->name }}</h1>
    <code>{{ print_r($directories) }}</code>
    <textarea name="editHTML" id="editHTML" cols="90" rows="100">{{ $htmlcontents }}</textarea>
</div>
</body>
</html>