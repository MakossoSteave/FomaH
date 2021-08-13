@extends('layouts.app')

@section('content')
@if(Auth::user())
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="bg-gradient-to-r from-blue-500 ">
        <div class=" relative bg-gradient-to-r from-gray-500 ">
            <div class=" max-w-6xl mx-auto px-1 sm:px-4">

                <div
                    class="flex justify-between items-center border-b-1 border-gray-100 py-6 md:justify-start md:space-x-10">

                    <div class="flex justify-start lg:w-0 lg:flex-1">
                        <h1 class="font-sans md:font-serif text-5xl text-center truncate">Intranet</h1>
                    </div>

                    <nav class="hidden md:flex space-x-10">
                        <div class="relative">
                            <ul>
                                <li><i class="fas fa-user"> </i>
                                    <a href="#">
                                        <span
                                            class="group text-white inline-flex items-center text-base font-medium hover:text-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            {{Str::upper(Auth::user()->name)}} </span>
                                    </a>
                                </li>
                                <li> <i class="fas fa-envelope text-blue-900 font-medium"></i>
                                    <a href="{{route('message',[Auth::user()->id]) }}">
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
        </div>

        <div class="text-gray">
            <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
                type="recherche" name="search" placeholder="Recherche">
            <button type="submit" class=" right-0 top-0 mt-5 mr-4">
                <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
                    viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve"
                    width="52px" height="52px">
                    <path
                        d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                </svg>
            </button>
        </div>

        <div class="columns">
            <div class="column is-one-fifth ml-4 mt-4">
                <aside class="menu">
                    <p class="menu-label">
                        Navigation
                    </p>
                    <ul class="menu-list">
                        <li><a href="{{ url('intranet/chapitre') }}">Cours</a></li>
                        <li><a>Exercices</a></li>
                        <li><a>Lives</a></li>
                        <li><a>Aide</a></li>
                    </ul>
                </aside>

            </div>
            @if($formationName)
            <div class="column">
                <h1 class="has-text-centered mb-4 is-size-3">{{$formationName->libelle}}</h1>
                <p class="mb-4">{{$formationName->description}}</p>
                    <div class="content" id="sommaire">
                        <ol class="is-upper-roman">
                            @foreach($sommaire as $sommaires)
                            @foreach($sommaires->cours as $cours)
                            <li>{{$cours->designation}}</li>
                            <ol>
                                @foreach($cours->chapitre as $chapitre)
                                <li>{{$chapitre->designation}}</li>
                                @endforeach
                            </ol>
                            @endforeach
                            @endforeach
                        </ol>
                    </div>
            </div>
            @else 
            <div class="column is-9">
            <div class="notification is-warning has-text-centered my-4">
            Vous ne suivez aucune formation
        </div>
            </div>
             @endif
        </div>

        <div class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20">

            <div class="grid gap-4 row-gap-5 sm:grid-cols-2 lg:grid-cols-4">
            
                <div class="flex flex-col justify-between p-5 border rounded shadow-sm">
                    <div>
                        <div class="flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-indigo-50">
                            <svg class="w-12 h-12 text-deep-purple-accent-400" stroke="currentColor"
                                viewBox="0 0 52 52">
                                <polygon stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none"
                                    points="29 13 14 29 25 29 23 39 38 23 27 23"></polygon>
                            </svg>
                        </div>
                        <h6 class="mb-2 font-semibold leading-5">Laravel</h6>
                        <p class="mb-3 text-sm text-gray-900">
                            aravel est un framework web open-source écrit en PHP respectant le principe
                            modèle-vue-contrôleur et
                            entièrement développé en programmation orientée objet. Laravel est distribué sous licence
                            MIT,
                            avec
                            ses sources hébergées sur GitHub.
                        </p>
                    </div>
                    <a href="/" aria-label=""
                        class="inline-flex items-center font-semibold transition-colors duration-200 text-deep-purple-accent-400 hover:text-deep-purple-800">
                        En savoir plus</a>
                </div>
                <div class="flex flex-col justify-between p-5 border rounded shadow-sm">
                    <div>
                        <div class="flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-indigo-50">
                            <svg class="w-12 h-12 text-deep-purple-accent-400" stroke="currentColor"
                                viewBox="0 0 52 52">
                                <polygon stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none"
                                    points="29 13 14 29 25 29 23 39 38 23 27 23"></polygon>
                            </svg>
                        </div>
                        <h6 class="mb-2 font-semibold leading-5">HTML </h6>
                        <p class="mb-3 text-sm text-gray-900">
                            Le HyperText Markup Language, généralement abrégé HTML ou dans sa dernière version HTML5,
                            est le
                            langage de balisage conçu pour représenter les pages web. Ce langage permet : d’écrire de
                            l’hypertexte, d’où son nom, de structurer sémantiquement la page, de mettre en forme le
                            contenu,
                            de
                            créer des formulaires de saisie
                        </p>
                    </div>
                    <a href="/" aria-label=""
                        class="inline-flex items-center font-semibold transition-colors duration-200 text-deep-purple-accent-400 hover:text-deep-purple-800">
                        En savoir plus</a>
                </div>
                <div class="flex flex-col justify-between p-5 border rounded shadow-sm">
                    <div>
                        <div class="flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-indigo-50">
                            <svg class="w-12 h-12 text-deep-purple-accent-400" stroke="currentColor"
                                viewBox="0 0 52 52">
                                <polygon stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none"
                                    points="29 13 14 29 25 29 23 39 38 23 27 23"></polygon>
                            </svg>
                        </div>
                        <h6 class="mb-2 font-semibold leading-5">PHP</h6>
                        <p class="mb-3 text-sm text-gray-900">
                            PHP: Hypertext Preprocessor, plus connu sous son sigle PHP, est un langage de programmation
                            libre,
                            principalement utilisé pour produire des pages Web dynamiques via un serveur HTTP, mais
                            pouvant
                            également fonctionner comme n'importe quel langage interprété de façon locale. PHP est un
                            langage
                            impératif orienté objet
                        </p>
                    </div>
                    <a href="/" aria-label=""
                        class="inline-flex items-center font-semibold transition-colors duration-200 text-deep-purple-accent-400 hover:text-deep-purple-800">
                        En savoir plus</a>
                </div>
                <div class="flex flex-col justify-between p-5 border rounded shadow-sm">
                    <div>
                        <div class="flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-indigo-50">
                            <svg class="w-12 h-12 text-deep-purple-accent-400" stroke="currentColor"
                                viewBox="0 0 52 52">
                                <polygon stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none"
                                    points="29 13 14 29 25 29 23 39 38 23 27 23"></polygon>
                            </svg>
                        </div>
                        <h6 class="mb-2 font-semibold leading-5">Javascript</h6>
                        <p class="mb-3 text-sm text-gray-900">
                            JavaScript est un langage de programmation de scripts principalement employé dans les pages
                            web
                            interactives et à ce titre est une partie essentielle des applications web. Avec les
                            technologies
                            HTML et CSS, JavaScript est parfois considéré comme l'une des technologies cœur du World
                            Wide
                            Web.
                        </p>
                    </div>
                    <a href="/" aria-label=""
                        class="inline-flex items-center font-semibold transition-colors duration-200 text-deep-purple-accent-400 hover:text-deep-purple-800">
                        En savoir plus</a>
                </div>
            </div>
        </div>
    </div>
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

</body>

</html>



@else
<div class="notification is-danger has-text-centered my-4">
Votre session a expiré !
</div>
<button type="button" class="group bg-white rounded-md text-gray-500 inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <a href="/">
                        <i class="fas fa-home"></i>
                            <span>Acceuil</span>
                        </a>

</button>
@endif
@endsection