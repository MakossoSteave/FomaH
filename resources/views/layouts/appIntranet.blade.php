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
     
    <section class="hero is-info">
    <div class="hero-body">
        <div class="columns">
            <div class="column is-9">
                <div class="container content">
                    <a id="home" class="icon is-medium" href="{{ url('intranet') }}"><i class="fas fa-home mr-2"></i>Accueil</a>
                    @if($cours)
                    <h1 class="title">Cours de <em>{{$cours->designation}}</em></h1>
                    @endif
                </div>
            </div>
            <nav class="column is-3">
                <div class="relative">
                    <ul>
                        <li><i class="fas fa-user"></i>
                            <a href="#">
                                <span
                                    class="group text-white inline-flex items-center text-base font-medium hover:text-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{Str::ucfirst(Auth::user()->name)}} </span>
                            </a>
                        </li>
                        <li> <i class="fas fa-envelope text-blue-900 font-medium"></i>
                            <a href="#">
                                <span
                                    class="group  text-base font-medium hover:text-blue-900 text-white">Messages
                                </span>
                            </a>
                        </li>

                    </ul>

                    <div class="relative">
                        <i class="fas fa-sign-out-alt"></i>
                        <a href="../stagiaire">
                            <button type="button"
                                class="group  text-white inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">

                                <span>Quitter</span>
                            </button></a>
                    </div>
            </nav>
        </div>
    </div>
</section>
<section class="section">
    <div class="container">
    <div class="columns">
        <div class="column is-3">
            <aside class="is-medium menu">
                <ul class="menu-list">
                    <li><a href="{{ url('intranet/chapitre') }}">Reprendre</a></li>
                </ul>
                <p class="menu-label">
                    Navigation
                </p>
                <ul class="menu-list">
                    <li><a href="{{ url('intranet/previousChapter') }}">Cours</a></li>
                    <li><a href="{{ url('intranet/previousQCM') }}">QCMs</a></li>
                    <li><a href="{{ url('intranet/previousExercices') }}">Exercices</a></li>
                    <li><a>Projets</a></li>
                    <li><a>Live</a></li>
                </ul>
            </aside>
        </div>
        
            @yield('content')


        <footer class="text-gray-100 bg-gray-800">
        <div class="max-w-3xl mx-auto py-6">
            <h1 class="text-center text-lg lg:text-2xl">
                Nous rejoindre <br>
                c'est avoir les conseils d'un professionnel
            </h1>
            <div class="flex justify-center mt-6">
                <div class=" bg-white rounded-md">
                    <div class="flex flex-wrap justify-between md:flex-row">
                        <input type="email"
                            class="m-1 p-2 appearance-none text-gray-700 text-sm focus:placeholder-transparent"
                            placeholder="Entrez votre email" aria-label="Entrez votre email">
                        <button
                            class="w-full m-1 p-2 text-sm bg-gray-800 rounded font-semibold uppercase lg:w-auto hover:bg-gray-700">
                            s'abonner
                        </button>
                    </div>
                </div>
            </div>
            <hr class="h-px mt-6 bg-gray-700 border-none">
            <div class="flex flex-col items-center justify-between mt-6 md:flex-row">
                <div>
                    <a href="#" class="text-xl font-bold text-gray-100 hover:text-gray-400">Perfect Ingénieurie</a>
                </div>
                <div class="flex mt-4 md:m-0">
                    <a href="" class="px-4 text-sm text-gray-100 font medium hover:text-gray-400">A propos de nous
                    </a>
                    <a href="" class="px-4 text-sm text-gray-100 font medium hover:text-gray-400">Contactez nous
                    </a>
                    <a href="" class="px-4 text-sm text-gray-100 font medium hover:text-gray-400">Blog</a>
                </div>
            </div>
        </div>
    </footer>
       

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="{{ URL::asset('/') }}js/addFieldForm.js"></script>
    <script src="{{ URL::asset('/') }}js/toggle.js"></script>
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