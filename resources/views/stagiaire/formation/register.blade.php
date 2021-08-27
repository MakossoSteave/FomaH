@extends('layouts.app')

@section('content')
@if(Auth::user())
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
                    </li>
                    <li> <i class="fas fa-envelope text-blue-900 font-medium"></i>
                        <a href="{{route('message',[Auth::user()->id])}}">

                            <span
                                class="group bg-white rounded-md text-base font-medium hover:text-blue-900 text-blue-500">Messages
                            </span>
                        </a>

                    </li>
                </ul>


            </div>
            <nav class="hidden md:flex space-x-10">
                <div class="relative">
                    <i class="fas fa-home"></i>
                    <button type="button"
                        class="group bg-white rounded-md text-gray-500 inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <a href="/stagiaire">
                            <span>Acceuil</span>
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
    <br>
    <section class="w-full max-w-2xl px-6 py-5 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800">
        <h2 class="text-3xl font-semibold text-center text-gray-800 dark:text-white">Formulaire d'inscription </h2>
        <p class="mt-3 text-center text-gray-600 dark:text-gray-400">Avec Formahuub vous allez glow Up !!</p>

        <div class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2 md:grid-cols-3">
            <a href="#"
                class="flex flex-col items-center px-4 py-3 text-gray-700 rounded-md dark:text-gray-200 hover:bg-blue-200 dark:hover:bg-blue-500">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                        clip-rule="evenodd" />
                </svg>

                <input class="mt-2"></span>
            </a>

            <a href="#"
                class="flex flex-col items-center px-4 py-3 text-gray-700 rounded-md dark:text-gray-200 hover:bg-blue-200 dark:hover:bg-blue-500">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                </svg>

                <input class="mt-2"></span>
            </a>

            <a href="#"
                class="flex flex-col items-center px-4 py-3 text-gray-700 rounded-md dark:text-gray-200 hover:bg-blue-200 dark:hover:bg-blue-500">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                </svg>

                <span class="mt-2">{{Auth::user()->email}}</span>
            </a>
        </div>

        <div class="mt-6 ">
            <div class="items-center -mx-2 md:flex">
                <div class="w-full mx-2">
                    <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200">Name</label>

                    <input
                        class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                        type="text" value="{{Auth::user()->name}}">
                </div>

                <div class="w-full mx-2 mt-4 md:mt-0">
                    <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200">E-mail</label>

                    <input
                        class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                        type="email" value="{{Auth::user()->email}}">
                </div>
            </div>

            <div class="w-full mt-4">
                <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200">Message
                    (facultatif)</label>

                <textarea
                    class="block w-full h-40 px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"></textarea>
            </div>

            <div class="flex justify-center mt-6">
                <button
                    class="px-4 py-2 text-white transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600">
                    Envoyé l'inscription </button>
            </div>
        </div>
    </section>
    <br>
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
                <a href="" class="px-4 text-sm text-gray-100 font medium hover:text-gray-400">A propos de nous </a>
                <a href="" class="px-4 text-sm text-gray-100 font medium hover:text-gray-400">Contactez nous </a>
                <a href="" class="px-4 text-sm text-gray-100 font medium hover:text-gray-400">Blog</a>
            </div>
        </div>
    </div>
</footer>


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