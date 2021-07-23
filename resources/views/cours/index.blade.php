@extends('layouts.app')

@section('content')

<div class="container">
    <div class="flex mt-4">
        <p class="control has-icons-right">
            <input class="input" type="search" placeholder="Rechercher..."/>
            <span class="icon is-small is-right"><i class="fas fa-search"></i></span>
        </p>
        <a href="{{ url('addCours')}}" class="has-icons-right" id="link-black">
            Ajouter une formation
            <span class="icon is-small is-right"><i class="fas fa-plus"></i></span>
        </a>
    </div>
    
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
                <div class="flex">
                    <p class="title is-4">Cours n°{{$cour->numero_cours}}</p>
                    <p class="title is-4"><span class="subtitle is-6">Créé par</span> {{$cour->formateurPrenom}} {{$cour->formateurNom}}</p>
                </div>
                <p class="subtitle is-6">{{$cour->designation}}</p>
            </div>
        </div>

            <div class="content">
                <div class="flex">
                    <div>
                        <p class="title is-6">Nombre de chapitres: {{$cour->nombre_chapitres}}</p>
                        <p class="title is-6">Prix: {{$cour->prix}}€</p>
                        <p class="title is-6">{{$cour->libelle}}</p>
                    </div>
                    <div class="flex-bottom">
                        <form action="" method="GET">
                            @csrf
                            <button type="submit" class="button button-card is-primary">Voir les chapitres</button>
                        </form>
                        <form action="{{ route('cours.edit', $cour->id_cours) }}" method="GET">
                            @csrf
                            <button type="submit" class="button button-card is-info">Modifier</button>
                        </form>
                            <p>
                                <a class = "button is-danger button-card modal-button" data-target = "#{{$cour->id_cours}}">Supprimer</a>
                            </p>
                            <div id="{{$cour->id_cours}}" class="modal">
                                <div class="modal-background"></div>
                                <div class="modal-card">
                                    <header class="modal-card-head">
                                    <p class="modal-card-title">Confirmez-vous la suppression de {{$cour->designation}}</p>
                                    <button class="delete" aria-label="close"></button>
                                    </header>
                                    <section class="modal-card-body">
                                        Souhaitez-vous supprimer le cours {{$cour->designation}} ?
                                    </section>
                                    <form action="{{ route('cours.destroy', $cour->id_cours) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <footer class="modal-card-foot">
                                    <button class="button is-success">Confirmer</button>
                                    </footer>
                                    </form>
                                </div>
                            </div>
                            <script>
                            $(".modal-button").click(function() {
                                var target = $(this).data("target");
                                $("html").addClass("is-clipped");
                                $(target).addClass("is-active");
                            });
                            
                            $(".delete").click(function() {
                                var target = $(".modal-button").data("target");
                                $("html").removeClass("is-clipped");
                                $(target).removeClass("is-active");
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endforeach

    @endif
</div>

@endsection