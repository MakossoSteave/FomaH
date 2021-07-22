@extends('layouts.app')

@section('content')

<div class="container">
    @if (session('success'))
        <div class="notification is-success has-text-centered my-4">
            {{ session('success') }}
        </div>
    @endif

    @if($cours->isEmpty())
        <div class="notification is-warning has-text-centered my-4">
            Aucun cours n'existe pour cette formation
        </div>
    @else

    @foreach ($cours as $cour)
    <div class="card my-6">
        <div class="card-content">
            <div class="media">
            <div class="media-left">
                <img class="image is-4by3" src="{{ URL::asset('/') }}img/cours/{{$cour->image}}" alt="Placeholder image">
            </div>
            <div class="media-content">
                <div class="flex-formateur">
                    <p class="title is-4">Cours n°{{$cour->numero_cours}}</p>
                    <p class="title is-4"><span class="subtitle is-6">Créé par</span> {{$cour->formateurPrenom}} {{$cour->formateurNom}}</p>
                </div>
                <p class="subtitle is-6">{{$cour->designation}}</p>
            </div>
        </div>

            <div class="content">
                <p class="title is-6">Nombre de chapitres: {{$cour->nombre_chapitres}}</p>
                <p class="title is-6">Prix: {{$cour->prix}}€</p>
                <p class="title is-6">{{$cour->libelle}}</p>
            </div>
        </div>
    </div>

    @endforeach

    @endif
</div>

@endsection