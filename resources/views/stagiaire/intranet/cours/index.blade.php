@extends('layouts.app')

@section('content')
@if(Auth::user())
<section class="hero is-info">
    <div class="hero-body">
        <div class="columns">
            <div class="column is-9">
                <div class="container content">
                    <a id="home" class="icon is-medium" href="{{ url('intranet') }}"><i class="fas fa-home mr-2"></i>Accueil</a>
                    <h1 class="title">Cours de <em>{{$cours->designation}}</em></h1>
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
                <p class="menu-label">
                    Navigation
                </p>
                <ul class="menu-list">
                    <li><a href="{{ url('intranet/cours') }}">Cours</a></li>
                    <li><a>Exercices</a></li>
                    <li><a>Lives</a></li>
                    <li><a>Aide</a></li>
                </ul>
            </aside>
        </div>
        <div class="column is-9">
        <div class="content is-medium">
            @foreach($chapitre->chapitre as $chap)
        <h3 class="title is-3">{{$chap->numero_chapitre}}. {{$chap->designation}}</h3>
        <video class="video" width="100%" controls>
            <source src="{{ URL::asset('/') }}video/chapitre/{{$chap->video}}" >
            Votre lecteur ne supporte pas ce type de video
        </video>
            @foreach($chap->section as $section)
                <div class="box mt-4">
                    <h4 id="const" class="title is-3 has-text-centered">{{$section->designation}}</h4>
                        <article class="message is-primary">
                            <span class="icon has-text-primary">
                            </span>
                            <div class="message-body">
                            {{$section->contenu}}
                            </div>
                        </article>
                        @if(! empty($section->image))
                            <img class="imageSection" src="{{ URL::asset('/') }}img/section/{{$section->image}}" alt="Placeholder image">
                        @endif
                </div>
            @endforeach
        @endforeach
    </div>
    <footer class="buttons paginate" class="mb-4">
        <a href="{{ url('intranet/qcm') }}" class="button is-success sizeButton">Faire le QCM</a>
    </footer>
    </div>
</div>
</div>
</div>
</section>
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