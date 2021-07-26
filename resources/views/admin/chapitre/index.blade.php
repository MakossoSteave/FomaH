@extends('layouts.app')

@section('content')

<div class="container">
    <div class="flex mt-4">
        <p class="control has-icons-right">
            <input class="input" type="search" placeholder="Rechercher..."/>
            <span class="icon is-small is-right"><i class="fas fa-search"></i></span>
        </p>
        <a href="{{ url('addChapitre')}}" class="has-icons-right" id="link-black">
            Ajouter un chapitre
            <span class="icon is-small is-right"><i class="fas fa-plus"></i></span>
        </a>
    </div>
    
    @if (session('success'))
        <div class="notification is-success has-text-centered my-4">
            {{ session('success') }}
        </div>
    @endif

    @foreach ($chapitres as $chapitre)
    <div class="card my-6">
        <div class="card-content">
            <div class="media">
            <div class="media-left">
                <img class="image is-4by3" src="{{ URL::asset('/') }}img/chapitre/{{$chapitre->image}}" alt="Placeholder image">
            </div>
            <div class="media-content">
                <div class="flex">
                    <p class="title is-4">Chapitre n°{{$chapitre->numero_chapitre}}</p>
                </div>
                <p class="subtitle is-6">{{$chapitre->designation}}</p>
            </div>
        </div>

            <div class="content">
                <div class="flex">
                    <div>
                    </div>
                    <div class="flex-bottom">
                        <form action="{{ route('chapitre.edit', $chapitre->id_chapitre) }}" method="GET">
                            @csrf
                            <button type="submit" class="button button-card is-info">Modifier</button>
                        </form>
                            <p>
                                <a class = "button is-danger button-card modal-button" data-target = "#{{$chapitre->id_chapitre}}">Supprimer</a>
                            </p>
                            <div id="{{$chapitre->id_chapitre}}" class="modal">
                                <div class="modal-background"></div>
                                <div class="modal-card">
                                    <header class="modal-card-head">
                                    <p class="modal-card-title">Confirmez-vous la suppression de {{$chapitre->designation}}</p>
                                    <button class="delete" aria-label="close"></button>
                                    </header>
                                    <section class="modal-card-body">
                                        Souhaitez-vous supprimer le chapitre {{$chapitre->designation}} ?
                                    </section>
                                    <form action="{{ route('chapitre.destroy', $chapitre->id_chapitre) }}" method="POST">
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

</div>

@endsection