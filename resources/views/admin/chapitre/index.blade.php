@extends('layouts.app')

@section('content')
@if(Auth::user() && Auth::user()->role_id==1)

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
        <button class="delete"></button>
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
            @if(! empty($chapitre->video))
            <div class="media-left">
                <video class="video is-4by3" width="320" height="240" controls>
                <source src="{{ URL::asset('/') }}video/chapitre/{{$chapitre->video}}">
                Your browser does not support the video tag.
                </video> 
            </div>
            @endif
           
            <div class="columns">
  <div class="column is-narrow">
    <div style="width: 600px;">
   
      <p class="title is-5">Chapitre n°{{$chapitre->numero_chapitre}}</p>
      <p class="subtitle">{{$chapitre->designation}}</p>
        @if(! empty($chapitre->image))
        <div class="media-left">
            <img class="image"  style="width: 60px;" src="{{ URL::asset('/') }}img/chapitre/{{$chapitre->image}}" alt="Placeholder image">
        </div>
        @endif
        <p class="subtitle is-half mt-4" > 
            <a class="{{ $chapitre->etat == 1 ? 'text-green-600' : 'text-red-600'  }} mb-8 " href="{{ route('etatChapitre', $chapitre->id_chapitre) }}">
                @if($chapitre->etat == 1) 
                Activé
                @else
                Désactivé
                @endif
            </a>
        </p>
    </div>
  </div>
    <div class="column">
        <div class="dropdown is-right is-hoverable">
          <div class="dropdown-trigger">
            <button class="button borderNone is-right"
                    aria-haspopup="true"
                    aria-controls="dropdown-menu">
              <span class="icon is-small is-right"><i class="fas fa-bars"></i></span>
              <span class="icon is-small">
              </span>
            </button>
          </div>
  
          <div class="dropdown-menu" 
               id="dropdown-menu" 
               role="menu">
            <div class="dropdown-content">
            <form action="{{ route('section', $chapitre->id_chapitre) }}" method="GET">
                @csrf
                <button type="submit" class="dropdown-item">Sections</button>
            </form>

            <form action="{{ route('qcm', $chapitre->id_chapitre) }}" method="GET">
                @csrf
                <button type="submit" class="dropdown-item">QCM</button>
            </form>
  
            <a href="#" class="dropdown-item">
            Exercices
            </a>

            <a href="{{ route('document', $chapitre->id_chapitre) }}" class="dropdown-item">
            Documents
            </a>
            </div>
          </div>
        </div>
    </div>
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
    {!! $chapitres->links() !!}
    @endif
</div>

@else
<div class="notification is-danger has-text-centered my-4">
@if(Auth::user() && Auth::user()->role_id!=1)
Vous n'êtes pas autorisé !
@else
Votre session a expiré !
@endif
</div>
<button type="button" class="group bg-white rounded-md text-gray-500 inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                         @if(Auth::user() && Auth::user()->role_id==2)
                        <a href="/centre">
                        @elseif(Auth::user() && Auth::user()->role_id==3)
                        <a href="/stagiaire">
                        @elseif(Auth::user() && Auth::user()->role_id==4)
                        <a href="/formateur">
                        @elseif(Auth::user() && Auth::user()->role_id==5)
                        <a href="/organisme">
                        @else
                        <a href="/">
                        @endif
                        <i class="fas fa-home"></i>
                            <span>Acceuil</span>
                        </a>

</button>
@endif
@endsection