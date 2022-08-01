
{{-- logout knop --}}
<a href="#"  id="logoutknop" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
{{-- einde logout knop --}}

tadaa