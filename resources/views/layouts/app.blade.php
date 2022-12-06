<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="{{ URL('assets/images/logo32col.png') }}" type="image/png" sizes="32x32">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Norg</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer>
        const myModal = document.getElementById('myModal')
        const myInput = document.getElementById('myInput')

        myModal.addEventListener('shown.bs.modal', () => {
            myInput.focus()
        })
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


</head>

<body>

    <div class="container center_div">
        <div class="container center_div fixed-top">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">

                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ URL('assets/images/logo32col.png') }}" alt="LogoNORG" width="auto"
                            height="auto">
                        Norg
                    </a>

                    @guest
                    @elseif(Auth::user()->role == 'Default')
                        <div class="collapse navbar-collapse " id="navbarSupportedContent">
                            <!-- Right Side Of Navbar -->

                            <ul class="navbar-nav ms-auto">
                                <!-- Authentication Links -->

                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>


                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </div>

                                </li>

                            </ul>
                        </div>
                        <main class="py-4">
                            @yield('onDefault')
                        </main>
                    @else
                        <div class="btn-group btn-group-lg" role="toolbar" aria-label="Toolbar with button groups">


                            @if (Auth::user()->role == 'Arzt' || Auth::user()->role == 'Sekretariat')
                            @else
                                @if (Request::segment(1) == 'sampleList')
                                    <button onclick="window.location = '/sampleList';" type="button"
                                        class="btn btn-outline-secondary " style="background: lightgray">
                                        Proben im Tank
                                    </button>
                                @else
                                    <button onclick="window.location = '/sampleList';" type="button"
                                        class="btn btn-outline-secondary ">
                                        Proben im Tank
                                    </button>
                                @endif


                                @if (Request::segment(1) == 'sentSamples')
                                    <button onclick="window.location = '/sentSamples';" type="button"
                                        class="btn btn-outline-secondary" style="background: lightgray">
                                        Verschickte Proben
                                    </button>
                                @else
                                    <button onclick="window.location = '/sentSamples';" type="button"
                                        class="btn btn-outline-secondary">
                                        Verschickte Proben
                                    </button>
                                @endif

                                @if (Request::segment(1) == 'removedSamples')
                                    <button onclick="window.location = '/removedSamples';" type="button"
                                        class="btn btn-outline-secondary" style="background: lightgray">
                                        Entfernte Proben
                                    </button>
                                @else
                                    <button onclick="window.location = '/removedSamples';" type="button"
                                        class="btn btn-outline-secondary">
                                        Entfernte Proben
                                    </button>
                                @endif

                                @if (Request::segment(1) == 'manageTanks')
                                    <button onclick="window.location = '/manageTanks';" type="button"
                                        class="btn btn-outline-secondary" style="background: lightgray">
                                        Tanks verwalten
                                    </button>
                                @else
                                    <button onclick="window.location = '/manageTanks';" type="button"
                                        class="btn btn-outline-secondary">
                                        Tanks verwalten
                                    </button>
                                @endif


                                @if (Auth::user()->role == 'Administrator')
                                    @if (Request::segment(1) == 'manageUser')
                                        <button onclick="window.location = '/manageUser';" type="button"
                                            class="btn btn-outline-secondary"style="background: lightgray">
                                            User verwalten
                                        </button>
                                    @else
                                        <button onclick="window.location = '/manageUser';" type="button"
                                            class="btn btn-outline-secondary">
                                            User verwalten
                                        </button>
                                    @endif
                                @endif
                            @endif

                        </div>
                        <div class="collapse navbar-collapse " id="navbarSupportedContent">
                            <!-- Right Side Of Navbar -->

                            <ul class="navbar-nav ms-auto">
                                <!-- Authentication Links -->

                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>


                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </div>

                                </li>

                            </ul>
                        </div>
                </nav>

                @if (Auth::user()->email == 'Platzhalter@Ueberschreiben.de')
                    <div class="alert alert-danger center_div" role="alert">
                        <b>Dieser Nutzer ist zum Einrichten der Applikation! <br>
                            Geben Sie einem anderen Nutzer die Rolle "Administrator" und entfernen danach diesen Nutzer
                            (Name: "AdminNutzer", E-Mail: "Platzhalter@Überschreiben.de")!
                        </b>
                    </div>
                @endif
            </div>

            @if (Auth::user()->email == 'Platzhalter@Ueberschreiben.de')
                <br><br><br>
            @endif

            <br><br>
            <main class="py-4">
                @yield('content')
            </main>
        @endguest

    </div>
    </div>

    </nav>
    <main class="py-4">
        @yield('login')
    </main>

    </div>


</body>
<footer class="text-center fixed-bottom">
    <div class="fixed-bottom text-center align-items-center" style="background-color: lightgray">
        <span class="me-5 text-muted">Information zum <a href="/imprint">Impressum</a> und <a
                href="/privacy">Datenschutz</a> erhalten Sie über die angegebenen Links.</span>
    </div>
</footer>

</html>
