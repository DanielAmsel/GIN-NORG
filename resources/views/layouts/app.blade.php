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


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


</head>

<body>

    <div class="container center_div">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">

                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ URL('assets/images/logo32col.png') }}" alt="LogoNORG" width="auto" height="auto">
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
                    @if(Auth::user()->role == 'Arzt' || Auth::user()->role == 'Sekretariat')
                        <a class="navbar-brand" href="{{ url('/sentSamples') }}">
                            Verschickte Proben
                        </a>
                    @else
                        <a class="navbar-brand" href="{{ url('/sampleList') }}">
                            Proben im Tank
                        </a>
                        <a class="navbar-brand" href="{{ url('/sentSamples') }}">
                            Verschickte Proben
                        </a>
                        <a class="navbar-brand" href="{{ url('/removedSamples') }}">
                            Entfernte Proben
                        </a>
                        <a class="navbar-brand" href="{{ url('/manageTanks') }}">
                            Tanks verwalten
                        </a>
                        @if (Auth::user()->role == 'Administrator')
                            <a class="navbar-brand" href="{{ url('/manageUser') }}">
                                User verwalten
                            </a>
                        @endif
                    @endif


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
            </div>

        </nav>

        @if (Auth::user()->email == "Platzhalter@Überschreiben.de")
            <div class="alert alert-danger center_div" role="alert">
                <b>Dieser Nutzer ist zum Einrichten der Applikation! <br>
                    Geben Sie einem anderen Nutzer die Rolle "Administrator" und entfernen danach diesen Nutzer (Name: "AdminNutzer", E-Mail: "Platzhalter@Überschreiben.de")!
                </b>
            </div>
        @endif
        
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
