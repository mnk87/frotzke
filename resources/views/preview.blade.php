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
        console.log(album);
        let photos = @json($photos);
        let pageLink = '{!! $newPageLink !!}';
        // console.log(pageLink);
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
        <div class="overzichtSubDiv">
            <h3 class="verySmallTitle">Nieuwe pagina link toevoegen aan pagina</h3>
            <p>Kopieer de onderstaande link met het knopje en voeg deze in op de pagina waar de andere links naar fotopagina's staan.<br>Gebruik hiervoor de editor hieronder.</p>
            <input type="text" name="photoPageLink" id="photoPageLink">
            <button type="button" id="photoPageLinkButton">Kopieren</button>
        </div>
        <div class="overzichtSubDiv">
            <h3 class="verySmallTitle">Versienummer veranderen van de css file</h3>
            <p>Ergens aan het begin van onderstaande code staat een link naar een css file genaamd "algemeen_resp.css" met daar een versienummer achter.
                verhoog dit versienummer zodat de volgende keer dat iemand op de pagina komt, hij/zij de aangepaste pagina te zien krijgt in plaats van de gecachede versie.
            </p>
        </div>
        <div class="overzichtSubDiv">
            <h3 class="verySmallTitle">Uploaden van aangepaste overzichtspagina en nieuwe fotopagina</h3>
            <p>Als je klaar bent met bovenstaande bewerkingen, is alles gereed om te uploaden. Klik op de volgende button om de albumpagina, 
                de foto's en de aangepaste overzichtspagina te uploaden naar puitenol.nl.</p>
            <p>LET OP, dit kan een tijdje duren. In een latere versie wordt de vooruitgang gevisualiseerd. Voorlopig nog niet, je krijgt een melding onder de knop als het klaar is.</p>
            <button type="button" id="toPuitenolButton">UPLOAD ALBUM EN OVERZICHTSPAGINA</button>
            <div id="uploadMessageBox"></div>
        </div>    
    </div>
    
        <textarea id="overviewEdit">{{ $htmlcontents }}</textarea>
</div>
</body>
</html>