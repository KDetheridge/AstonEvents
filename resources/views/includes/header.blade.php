<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">Aston Events</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

            <li class="nav-item">
                <a class="nav-link" href="/list">Events</a>
            </li>
            <li class="nav-item">
                @if (is_null(Session::get('OrganiserID')))
                <a class="nav-link" href={{url('login')}}>
                    Organiser Login
                </a>
                @else
                <a class="nav-link" href={{url('logoutUser')}}>
                    Log out
                </a>

                @endif
            </li>
        </ul>



    </div>


</nav>