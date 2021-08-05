@extends('layouts.app')

@section('content')

<div class="container">
    <div class="flex mt-4">
        <p class="control has-icons-right">
            <input class="input" type="search" placeholder="Rechercher..."/>
            <span class="icon is-small is-right"><i class="fas fa-search"></i></span>
        </p>
        <a href="{{ route('addDocument', request()->route('id') ) }}" class="has-icons-right" id="link-black">
            Ajouter un document
            <span class="icon is-small is-right"><i class="fas fa-plus"></i></span>
        </a>
    </div>
    
    @if (session('success'))
        <div class="notification is-success has-text-centered my-4">
            {{ session('success') }}
        </div>
    @endif

    @if($documents->isEmpty())
        <div class="notification is-warning has-text-centered my-4">
            Aucun document n'existe pour ce chapitre
        </div>
    @else

    @foreach ($documents as $document)
    <div class="card my-6">
        <div class="card-content">
            <div class="media">
            @if(! empty($document->lien))
            <div class="media-left">
                <embed class="image is-4by3" src="{{ URL::asset('/') }}doc/chapitre/{{$document->lien}}" />
            </div>
            @endif
            <div class="media-content">
                <div class="flex">
                    <p class="title is-4">{{$document->designation}}</p>
                </div>
            </div>
        </div>

            <div class="content">
                <div class="flex">
                    <div>
                    </div>
                    <div class="flex-bottom">
                        <form action="{{ route('document.edit', $document->id) }}" method="GET">
                            @csrf
                            <button type="submit" class="button button-card is-info">Modifier</button>
                        </form>
                            <p>
                                <a class = "button is-danger button-card modal-button" data-target = "#{{$document->id}}">Supprimer</a>
                            </p>
                            <div id="{{$document->id}}" class="modal">
                                <div class="modal-background"></div>
                                <div class="modal-card">
                                    <header class="modal-card-head">
                                    <p class="modal-card-title">Confirmez-vous la suppression de {{$document->designation}}</p>
                                    <button class="delete" aria-label="close"></button>
                                    </header>
                                    <section class="modal-card-body">
                                        Souhaitez-vous supprimer la catégorie {{$document->designation}} ?
                                    </section>
                                    <form action="{{ route('document.destroy', $document->id) }}" method="POST">
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