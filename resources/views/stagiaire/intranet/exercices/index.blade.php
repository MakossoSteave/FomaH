@extends('layouts.app')

@section('content')
@if(Auth::user())
{{--dd($exercices)--}}
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
            <h1 class="has-text-centered">Exercice</h1>
            @foreach($exercices as $exercice)
            <div class="box mt-4">
                    <article class="message is-primary">
                        <span class="icon has-text-primary">
                        </span>
                        <div class="message-body">
                        {{$exercice->enonce}}
                        </div>
                    </article>
                    @if(!empty($exercice->image))
                        <img class="imageSection" src="{{ URL::asset('/') }}img/exercice/{{$exercice->image}}" alt="Placeholder image">
                    @endif
            </div>
                @foreach($exercice->questions_exercice as $question)
                <p>{{$question->question}}</p>
                    <button class="button is-link is-outlined correctionShow mb-4" id="{{$question->id}}">Voir la correction</button>
                    <div id="correctionToggle{{$question->id}}" style="display: none;">
                    @foreach($question->questions_correction as $correction)
                        <p>{{$correction->reponse}}</p>
                        @if(!empty($correction->image))
                        <img class="imageSection" src="{{ URL::asset('/') }}img/exercice/{{$correction->image}}" alt="Placeholder image">
                        @endif
                    @endforeach
                    </div>
                @endforeach
            @endforeach
        </div>
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