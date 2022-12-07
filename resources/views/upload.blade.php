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
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#albumModal">Nieuw Album</button>
    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAlbumModal">Verwijder Album</button>
    <div class="albumDiv"> 
        @foreach ($albums as $album)
        <a href="/upload/albums/{{ $album->id }}">
            <div class="albumCard">
                <h3 class="albumTitle">{{ $album->name }}</h3>
                <p>aantal foto's {{ $album->photos->count() }} </p>
                @if($album->bgimg)
                    <p>achtergrondplaatje voor deze pagina: {{ $album->bgimg }}</p>
                    <img src="{{ url('storage/'.$album->foldername.'/'.$album->bgimg) }}" alt="" class="albumBgImg">
                @else
                    <p>geen achtergrondplaatje ingesteld.</p>
                @endif
            </div>
        </a>
        @endforeach
    </div>
    <!-- modal voor aanmaken album -->
    <div class="modal" id="albumModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nieuw album aanmaken</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nameInput" class="form-label">Naam</label>
                    <input type="text" class="form-control" id="nameInput" placeholder="Naam">
                </div>
                <div class="mb-3">
                    <label for="folderNameInput" class="form-label">Mapnaam</label>
                    <input type="email" class="form-control" id="folderNameInput" placeholder="Mapnaam">
                </div>
                <div class="mb-3">
                    <label for="yearFolderInput" class="form-label">Jaarmapnaam</label>
                    <input type="email" class="form-control" id="yearFolderInput" placeholder="Jaarmapnaam">
                </div>
                <div class="mb-3">
                    <label for="bgImgInput" class="form-label">Achtergrondafbeelding</label>
                    <input class="form-control" type="file" id="bgImgInput">
                    <p id="saveAlbumError" class="errorMessage"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveAlbumButton">Save changes</button>
            </div>
        </div>
    </div>
    </div>
    <!-- einde modal -->
    <!-- delete modal -->
    <div class="modal" id="deleteAlbumModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Album verwijderen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="albumSelect" class="form-label">Naam</label>
                    <select name="albumSelect" class="form-select" id="albumSelect">
                        <option selected>Selecteer een album om te verwijderen.</option>
                        @foreach ($albums as $album)
                            <option value="{{ $album->id }}">{{ $album->name }}</option>
                        @endforeach
                    </select>
                    <p id="deleteAlbumError" class="errorMessage"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="deleteAlbumButton">Save changes</button>
            </div>
        </div>
    </div>
    <!-- einde delete modal -->
</div> <!-- einde container div --> 


</div>
</body>
</html>