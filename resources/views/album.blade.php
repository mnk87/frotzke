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
    @if (session('status'))
    <div class="alert alert-success" id="alertBox">
        {{ session('status') }}
    </div>
    @endif
    <div id="uploadFilesDiv">
        <h1 class="uploadTitle">Foto's uploaden</h1>
        <form action="/upload/albums/uploadMultiple" method="post" enctype="multipart/form-data">
            @csrf
            <button type="button" name="photosButton" id="photosButton">Selecteer Bestanden</button>
            <label id="photosButtonLabel" for="photosButton">Geen bestanden geselecteerd.</label>
            <input type="file" name="photos[]" id="photos" accept="image/*" multiple>
            <input type="hidden" name="albumid" value="{{ $album->id }}">
            <button type="submit" id="uploadSubmit" name="submit" class="submitBtn" disabled>Uploaden</button>
        </form>
    </div>
    <div id="photoDiv">
        <div id="photoListDiv">
        @foreach ($photos as $photo)
            <div class="photoListItem" data-filename="{{ $photo->filename }}" data-photoid="{{ $photo->id }}">
                <div class="photoInfo" >
                    <button type="button" class="deleteBtn" data-photoid="{{ $photo->id }}">x</button>
                    <h1>{{ $photo->filename }}</h1>
                    <p>{{ $photo->id }}</p>
                </div>
                <img src="{{ url('storage/'.$album->foldername.'/'.$photo->filename) }}" alt="">
            </div>
        @endforeach
        </div>
        <div id="rightSide">
            <div id="photoDisplayDiv">
                <img id="bigDisplay" src="@if($photos->first()) {{ url('storage/'.$album->foldername.'/'.$photos->first()->filename) }} @endif" alt="" data-photoid="">
            </div>
            <div id="bottomRight">
                <button type="button" id="brleft" name="brleft" class="bottomControls">Linksom Draaien</button>
                <button type="button" id="brright" name="brright" class="bottomControls">Rechtsom Draaien</button>
            </div>
            
        </div>
    </div>
    @if(count($photos) > 0)
    <a href="/upload/preview/{{ $album->id }}">volgende pagina</a>
    @endif
</div>
</body>
</html>