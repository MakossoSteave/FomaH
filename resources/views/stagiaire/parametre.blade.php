@extends('layouts.app')

@section('content')


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


</div>

<!-- This example requires Tailwind CSS v2.0+ -->
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 text-center">
            Parametre
        </h3>

    </div>
    <div class="sm:w-3/1 px-20">
        <dl>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Nom
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{$id->name}}

                </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Prénom
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                 
                {{$User->prenom}}
                <input type="text" class="focus:outline-blue focus:ring focus:border-blue-300 p-2"
                    
                    placeholder="Prénom">
                    <a href="#" class="p-16 font-medium text-indigo-600 hover:text-indigo-500">
                        modifier
                    </a>
                </dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Status
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                {{$role}}
                </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Adresse de messagerie

                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{$id->email}}
                    <input type="text" class="focus:outline-blue focus:ring focus:border-blue-300 p-2"
                        placeholder="Email">
                    <a href="#" class="p-16 font-medium text-indigo-600 hover:text-indigo-500">
                        modifier
                    </a>

                </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                   Téléphone

                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{$User->telephone}}
                    <input type="text" class="focus:outline-blue focus:ring focus:border-blue-300 p-2"
                   
                    placeholder="Numéro de téléphone">
                    <a href="#" class="p-16 font-medium text-indigo-600 hover:text-indigo-500">
                        modifier
                    </a>

                </dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Date de création du compte
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{$id->created_at}}
                </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Préference
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <div class="ml-4 flex-shrink-0">
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Ajouter
                        </a>
                    </div>
                </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    mots de passe actuel
                </dt>
                <input class="focus:outline-blue focus:ring focus:border-blue-300" type="password"
                    placeholder="Mots de passe actuel">
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Nouveau mots de passe
                </dt>
                <input class="focus:outline-blue focus:ring focus:border-blue-300" type="password"
                    placeholder="Nouveau mots de passe">
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                    modifier
                </a>
            </div>

        </dl>
    </div>
</div>
<br>
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

@endsection