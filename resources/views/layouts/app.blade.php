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

        <nav class="navbar container is-fluid" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            
        <div class="py-2 bg-indigo-100 lg:bg-white flex justify-center lg:justify-start lg:px-12">
            <div class="cursor-pointer flex items-center">
                <div>
                    <a class="navbar-item" href="/"><svg class="w-10 text-indigo-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 225 225" style="enable-background:new 0 0 225 225;" xml:space="preserve">
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
                <div class="text-2xl text-indigo-800 tracking-wide ml-2 font-semibold">Formahuub</div>
            </div>
        </div>

            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <a class="navbar-item custom-margin">
                Session
            </a>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link custom-margin">
                Cursus
                </a>

                <div class="navbar-dropdown">
                <a class="navbar-item">
                    Mots-clés
                </a>
                </div>
            </div>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link custom-margin">
                Cours
                </a>

                <div class="navbar-dropdown">
                <a class="navbar-item">
                    Chapitres
                </a>
                <a class="navbar-item">
                    Projets
                </a>
                <a class="navbar-item">
                    Exercices
                </a>
                <a class="navbar-item">
                    Documents
                </a>
                <a class="navbar-item">
                    QCM
                </a>
                </div>
            </div>

            <a class="navbar-item custom-margin">
                Formateur
            </a>

            <a class="navbar-item custom-margin">
                Stagiaire
            </a>

            <a class="navbar-item custom-margin">
                Titre
            </a>

            <a class="navbar-item custom-margin">
                Catégorie
            </a>

        </div>
        </nav>

        @endif
        @if(Auth::user()->role_id ==2)

        @endif

        @endguest

        <main class="">

            @yield('content')
        </main>
    </div>
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