<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css?family=Source+Code+Pro|Roboto&display=swap" rel="stylesheet">
    <link
        href=" https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap "
        rel=" feuille de style ">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css">
    <link rel="stylesheet" href="{{ URL::asset('/') }}css/app.css" />
    <link rel="shortcut icon" href="{{ URL::asset('/') }}/favicon.ico">
<link rel="icon" type="image/png" href="{{ URL::asset('/') }}/favicon.ico">
</head>


<body class="">
    <div id="app">
        @guest
        @if (Route::has('login'))

        @endif

        @if (Route::has('register'))

        @endif
        @else
        @if (Auth::user()->role_id==1)

        <div class="container is-fluid">
            <div class="user">
                <div>
                <span class="icon is-medium">
                    <i class="fas fa-user-circle"></i>
                    {{ Auth::user()->name }}
                </span>
                </div>

                <div>
                    <span class="icon is-medium mr-4">
                        <i class="fas fa-envelope"></i>
                    </span>

                    <span class="icon is-medium">
                        <form action="{{ route('logout')}}" method="POST">
                            @csrf
                            <button id="logout-form" class="submit"><i class="fas fa-power-off"></i></button>
                        </form>
                    </span>
                </div>
            </div>

            <nav class="navbar container is-fluid" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                
            <div class="py-2 bg-indigo-100 lg:bg-white flex justify-center lg:justify-start lg:px-12">
                <div class="cursor-pointer flex items-center">
                    <div>
                        <a class="navbar-item" href="/admin"><svg class="w-10 text-indigo-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 225 225" style="enable-background:new 0 0 225 225;" xml:space="preserve">
                                <style type="text/css">
                                .st0 {
                                    fill: none;
                                    stroke: currentColor;
                                    stroke-width: 20;
                                    stroke-linecap: round;
                                    stroke-miterlimit: 3;
                                }
                                </style>
                                <g transform="matrix( 1, 0, 0, 1, 0,0) ">
                                    <g>
                                        <path id="Layer0_0_1_STROKES" class="st0" d="M173.8,151.5l13.6-13.6 M35.4,89.9l29.1-29 M89.4,34.9v1 M137.4,187.9l-0.6-0.4     M36.6,138.7l0.2-0.2 M56.1,169.1l27.7-27.6 M63.8,111.5l74.3-74.4 M87.1,188.1L187.6,87.6 M110.8,114.5l57.8-57.8"></path>
                                    </g>
                                </g>
                            </svg>
                        </a>
                    </div>
                    <div class="text-2xl text-indigo-800 tracking-wide ml-2 font-semibold">HubDigitForma</div>
                </div>
            </div>

                <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="navbarBasicExample" class="navbar-menu">
                <a class="navbar-item">
                    Session
                </a>

                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link" href="{{ url('cursus')}}">
                    Cursus
                    </a>

                    <div class="navbar-dropdown">
                    <a class="navbar-item">
                        Mots-clés
                    </a>
                    </div>
                </div>

                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link" href="{{ url('cours')}}">
                    Cours
                    </a>

                    <div class="navbar-dropdown">
                    <a class="navbar-item">
                        Projets
                    </a>
                    <a class="navbar-item">
                        Exercices
                    </a>
                    <a class="navbar-item">
                        Documents
                    </a>
                    <a class="navbar-item" href="{{ url('qcm')}}">
                        QCM
                    </a>
                    </div>
                </div>

                <a class="navbar-item">
                    Formateur
                </a>

                <a class="navbar-item">
                    Stagiaire
                </a>

                <a class="navbar-item">
                    Titre
                </a>

                <a class="navbar-item" href="{{ url('categorie')}}">
                    Catégorie
                </a>

            </div>
            </nav>
        </div>

        @endif
        @if(Auth::user()->role_id ==4)

        <div class="relative bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex justify-between items-center border-b-2 border-gray-100 py-6 md:justify-start md:space-x-10">

            <div class="flex justify-start lg:w-0 lg:flex-1">
                <ul>
                    <li><i class="fas fa-user"> </i>
                        <a href="#">
                            <span
                                class="group bg-white rounded-md text-blue-500 inline-flex items-center text-base font-medium hover:text-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{Auth::user()->name}} </span>
                        </a>
                        <div class="absolute top-5 right-0 h-8 w-18 p-4">
                            <button class="js-change-theme focus:outline-none">🌙</button>
                        </div>
                    </li>
                    <li> <i class="fas fa-envelope text-blue-900 font-medium"></i>
                        <a href="{{route('message',[Auth::user()->id]) }}">
                            <span
                                class="group bg-white rounded-md text-base font-medium hover:text-blue-900 text-blue-500">Messages
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <nav class="hidden md:flex space-x-10">
                
                <div class="relative">
                    <i class="fas fa-sliders-h "></i>
                    <button type="button"
                        class="group bg-white rounded-md text-gray-500 inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <a href="{{ route('parametre', [Auth::user()->id]) }}">
                            <span>Parametre(formateur.index)</span>
                        </a>

                    </button>
                </div>
                <div class="relative">
                    <i class="fas fa-sliders-h "></i>
                    <button type="button"
                        class="group bg-white rounded-md text-gray-500 inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <a href="{{ route('dropdownn', [Auth::user()->id]) }}">
                            <span>Déclaration de compétence</span>
                        </a>
                    </button>
                </div>

                <div class="relative">
                    <button type="button"
                        class="group bg-white rounded-md text-gray-500 inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="flex-shrink-0 h-6 w-6 text-indigo-600 " xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span>Notification</span>
                    </button>
                </div>
            </nav>
            <div class="hidden md:flex items-center justify-end md:flex-1 lg:w-0">

                <a href="{{ route('logout')}}"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();" class=" ml-8
        whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border
        border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600
        hover:bg-indigo-700">
                    Deconnection
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

    </div>

        @endif

        @endguest

        <main class="">

            @yield('content')
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="{{ URL::asset('/') }}js/addFieldForm.js"></script>
    <script src="https://unpkg.com/popper.js@1/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/tippy.js@4"></script>
    <script>
    //Init tooltips
    tippy('.link', {
        placement: 'bottom'
    })

    //Toggle mode
    const toggle = document.querySelector('.js-change-theme');
    const body = document.querySelector('body');
    const profile = document.getElementById('profile');


    toggle.addEventListener('click', () => {

        if (body.classList.contains('text-gray-900')) {
            toggle.innerHTML = "☀️";
            body.classList.remove('text-gray-900');
            body.classList.add('text-gray-100');
            profile.classList.remove('bg-white');
            profile.classList.add('bg-gray-900');
        } else {
            toggle.innerHTML = "🌙";
            body.classList.remove('text-gray-100');
            body.classList.add('text-gray-900');
            profile.classList.remove('bg-gray-900');
            profile.classList.add('bg-white');

        }
    });
    </script>
</body>


</html>