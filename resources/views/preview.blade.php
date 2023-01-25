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
    <script>
        let album = @json($album);
        let photos = @json($photos);
        let pageLink = '{!! $newPageLink !!}';
        console.log(pageLink);
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
    <div class="pageEditDiv">
        <h2 class="smallTitle">overzichtspagina bewerken</h2>
        <div id="PageLinkInputDiv">
            <input type="text" name="photoPageLink" id="photoPageLink">
            <button type="button" id="photoPageLinkButton">Kopieren</button>
        </div>    
    </div>
    
        <textarea id="overviewEdit">{{ $htmlcontents }}</textarea>
</div>
</body>
</html>