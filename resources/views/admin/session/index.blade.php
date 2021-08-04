@extends('layouts.app')

@section('content')

<div class="container">
    <div class="flex mt-4">
        <p class="control has-icons-right">
            <input class="input" type="search" placeholder="Rechercher..."/>
            <span class="icon is-small is-right"><i class="fas fa-search"></i></span>
        </p>
        <a href="{{ route('addSession') }}" class="has-icons-right" id="link-black">
            Ajouter une session
            <span class="icon is-small is-right"><i class="fas fa-plus"></i></span>
        </a>
    </div>
    
    @if (session('success'))
        <div class="notification is-success has-text-centered my-4">
            {{ session('success') }}
        </div>
    @endif

    @if($sessions->isEmpty())
        <div class="notification is-warning has-text-centered my-4">
            Aucune session n'existe
        </div>
    @else

    @foreach ($sessions as $session)
    <div class="card my-6">
        <div class="card-content">
            <div class="media">
            <div class="media-content">
                <p class="title is-4">{{$session->date_debut}}</p>
                <p class="subtitle is-6">{{$session->date_fin}}</p>
            </div>
        </div>

            <div class="content">
                <div class="flex">
                    <div>
                        <a class="{{ $session->etat == 1 ? 'text-green-600' : 'text-red-600'  }} mb-8" href="{{ route('etatSession', $session->id) }}">
                        @if($session->etat == 1) 
                        Activé
                        @else
                        Désactivé
                        @endif
                        </a>
                    </div>
                    <div class="flex-bottom">
                        <form action="{{ route('session.edit', $session->id) }}" method="GET">
                            @csrf
                            <button type="submit" class="button button-card is-info">Modifier</button>
                        </form>
                            <p>
                                <a class = "button is-danger button-card modal-button" data-target = "#{{$session->id}}">Supprimer</a>
                            </p>
                            <div id="{{$session->id}}" class="modal">
                                <div class="modal-background"></div>
                                <div class="modal-card">
                                    <header class="modal-card-head">
                                    <p class="modal-card-title">Suppression de la session du {{$session->date_debut}}</p>
                                    <button class="delete" aria-label="close"></button>
                                    </header>
                                    <section class="modal-card-body">
                                        Souhaitez-vous supprimer la session du {{$session->date_debut}} au {{$session->date_fin}} ?
                                    </section>
                                    <form action="{{ route('session.destroy', $session->id) }}" method="POST">
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