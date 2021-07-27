@extends('layouts.app')

@section('content')

<div class="container">
    <div class="flex mt-4">
        <p class="control has-icons-right">
            <input class="input" type="search" placeholder="Rechercher..."/>
            <span class="icon is-small is-right"><i class="fas fa-search"></i></span>
        </p>
        <a href="{{ route('addChapitre', $idCours ) }}" class="has-icons-right" id="link-black">
            Ajouter un chapitre
            <span class="icon is-small is-right"><i class="fas fa-plus"></i></span>
        </a>
    </div>
    
    @if (session('success'))
        <div class="notification is-success has-text-centered my-4">
            {{ session('success') }}
        </div>
    @endif

    @if($chapitres->isEmpty())
        <div class="notification is-warning has-text-centered my-4">
            Aucun chapitre n'existe pour ce cours
        </div>
    @else

    @foreach ($chapitres as $chapitre)
    <div class="card my-6">
        <div class="card-content">
            <div class="media">
            @if(! empty($chapitre->image))
            <div class="media-left">
                <img class="image is-4by3" src="{{ URL::asset('/') }}img/chapitre/{{$chapitre->image}}" alt="Placeholder image">
            </div>
            @endif
            <div class="media-content">
                <div class="flex">
                    <p class="title is-4">chapitre n°{{$chapitre->numero_chapitre}}</p>
                   <!-- <p class="title is-4"><span class="subtitle is-6">Créé par</span> {{$chapitre->formateurPrenom}} {{$chapitre->formateurNom}}</p>-->
                </div>
                <p class="subtitle is-6">{{$chapitre->designation}}</p>
            </div>
            <div class="media-content">
                <div class="flex">
               
                <p class="title column is-9 {{ ! empty($chapitre->image) ? 'is-offset-7' : 'is-offset-8'  }}"> 
                <a class="{{ $chapitre->etat == 1 ? 'text-green-600' : 'text-red-600'  }} mb-8" href="{{ route('etatChapitre', $chapitre->id_chapitre) }}">
                        @if($chapitre->etat == 1) 
                        Activé
                        @else
                        Désactivé
                        @endif
                        </a>
                </p>
                </div>
            </div>
        </div>

            <div class="content">
                <div class="flex">
                    <div>
                      <!-- <p class="title is-6">Nombre de sections: {{$chapitre->nombre_chapitres}}</p>-->
                      @if(! empty($chapitre->video))
                        <div class="media-left">
                            <video class="video is-4by3" width="320" height="240" controls>
                            <source src="{{ URL::asset('/') }}video/chapitre/{{$chapitre->video}}">
                            Your browser does not support the video tag.
                            </video> 
                        </div>
                        @endif
                        <p class="title is-6">{{$chapitre->libelle}}</p>
                    </div>
                    <div class="flex-bottom">
                        <form action="{{ route('section', $chapitre->id_chapitre) }}" method="GET">
                            @csrf
                            <button type="submit" class="button button-card is-primary">Voir les sections</button>
                        </form>
                        <form action="{{ route('chapitre.edit', $chapitre->id_chapitre) }}" method="GET">
                            @csrf
                            <button type="submit" class="button button-card is-info">Modifier</button>
                        </form>
                            <p>
                                <a class = "button is-danger button-card modal-button" data-target = "#{{$chapitre->id_cours}}">Supprimer</a>
                            </p>
                            <div id="{{$chapitre->id_cours}}" class="modal">
                                <div class="modal-background"></div>
                                <div class="modal-card">
                                    <header class="modal-card-head">
                                    <p class="modal-card-title">Confirmez-vous la suppression de {{$chapitre->designation}}</p>
                                    <button class="delete" aria-label="close"></button>
                                    </header>
                                    <section class="modal-card-body">
                                        Souhaitez-vous supprimer le chapitre {{$chapitre->designation}} ?
                                    </section>
                                    <form action="{{ route('chapitre.destroy', $chapitre->id_cours) }}" method="POST">
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
    {!! $chapitres->links() !!}
    @endif
</div>

@endsection