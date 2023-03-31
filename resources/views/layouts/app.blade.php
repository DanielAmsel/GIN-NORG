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

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.1/fh-3.3.1/datatables.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#myTables').DataTable( {
                fixedHeader: {
            header: true},
                lengthMenu: [
            [25, 50, 100, -1],
            [25, 50, 100, 'All']
        ]
            } );
        } );
        </script>
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.1/fh-3.3.1/datatables.min.css"/>

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
                                        {{__('messages.Proben im Tank')}}
                                    </button>
                                @else
                                    <button onclick="window.location = '/sampleList';" type="button"
                                        class="btn btn-outline-secondary ">
                                        {{__('messages.Proben im Tank')}}
                                    </button>
                                @endif


                                @if (Request::segment(1) == 'sentSamples')
                                    <button onclick="window.location = '/sentSamples';" type="button"
                                        class="btn btn-outline-secondary" style="background: lightgray">
                                        {{__('messages.Verschickte Proben')}}
                                    </button>
                                @else
                                    <button onclick="window.location = '/sentSamples';" type="button"
                                        class="btn btn-outline-secondary">
                                        {{__('messages.Verschickte Proben')}}
                                    </button>
                                @endif

                                @if (Request::segment(1) == 'removedSamples')
                                    <button onclick="window.location = '/removedSamples';" type="button"
                                        class="btn btn-outline-secondary" style="background: lightgray">
                                        {{__('messages.Entfernte Proben')}}
                                    </button>
                                @else
                                    <button onclick="window.location = '/removedSamples';" type="button"
                                        class="btn btn-outline-secondary">
                                        {{__('messages.Entfernte Proben')}}
                                    </button>
                                @endif

                                @if (Request::segment(1) == 'manageTanks')
                                    <button onclick="window.location = '/manageTanks';" type="button"
                                        class="btn btn-outline-secondary" style="background: lightgray">
                                        {{__('messages.Tanks verwalten')}}
                                    </button>
                                @else
                                    <button onclick="window.location = '/manageTanks';" type="button"
                                        class="btn btn-outline-secondary">
                                        {{__('messages.Tanks verwalten')}}
                                    </button>
                                @endif


                                @if (Auth::user()->role == 'Administrator')
                                    @if (Request::segment(1) == 'manageUser')
                                        <button onclick="window.location = '/manageUser';" type="button"
                                            class="btn btn-outline-secondary"style="background: lightgray">
                                            {{__('messages.User verwalten')}}
                                        </button>
                                    @else
                                        <button onclick="window.location = '/manageUser';" type="button"
                                            class="btn btn-outline-secondary">
                                            {{__('messages.User verwalten')}}
                                        </button>
                                    @endif
                                @endif
                            @endif

                        </div>
                        <div class="collapse navbar-collapse " id="navbarSupportedContent">
                            <!-- Right Side Of Navbar -->

                            <ul class="navbar-nav ms-auto">
                                <!-- Authentication Links and DB Dump -->

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

                                        @if (Auth::user()->role == 'Arzt' || Auth::user()->role == 'Sekretariat')
                                        @else
                                        <a class="dropdown-item" href="/download">{{__('messages.Datenbank dump')}}</a>
                                        @endif
                                    </div>

                                </li>

                            </ul>
                        </div>
                </nav>

                @if (Auth::user()->email == 'admin@norg.de')
                    <div class="alert alert-danger center_div" role="alert">
                        <b>{{__('messages.Dieser Nutzer ist zum Einrichten der Applikation!')}}<br>
                            {{__('messages.Geben Sie einem anderen Nutzer die Rolle Administrator und entfernen danach diesen Nutzer (Name: admin, E-Mail: admin@norg.de)!')}}
                        </b>
                    </div>
                @endif
            </div>

            @if (Auth::user()->email == 'admin@norg.de')
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
        <span class="me-5 text-muted">{{__('messages.Information zum ')}}<a href="/imprint">{{__('messages.Impressum ')}}</a>{{__('messages.und ')}}<a
                href="/privacy">{{__('messages.Datenschutz ')}}</a>{{__('messages.erhalten Sie über die angegebenen Links.')}}</span>
    </div>
</footer>

</html>
