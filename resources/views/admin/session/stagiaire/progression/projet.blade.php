@extends('layouts.app')

@section('content')
@if(Auth::user() && Auth::user()->role_id==1)

<div class="container">
    <div class="flex mt-4">
        <p class="control has-icons-right">
            <input class="input" type="search" placeholder="Rechercher..."/>
            <span class="icon is-small is-right"><i class="fas fa-search"></i></span>
        </p>


    </div>

    @if (session('success'))
        <div class="notification is-success has-text-centered my-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="notification is-danger has-text-centered my-4">
        <button class="delete"></button>
            {{ session('error') }}
        </div>
    @endif

    @if($projets->isEmpty())
        <div class="notification is-warning has-text-centered my-4">
            Aucun projet n'existe pour ce stagiaire
        </div>
    @else


    <div class="columns is-multiline mt-3">
    @foreach($projets as $projet)
            <div class="column is-4">
                <div class="card is-shady">
                    <div class="card-image">
                         <img src="{{ URL::asset('/') }}img/projet.jpg" alt="" class="img is-4by3">
                    </div>
                <div class="card-content  @if($projet->resultat_description && $projet->statut_reussite!==null) {{$projet->statut_reussite==1? 'has-background-success':'has-background-danger'}} @endif">
                    <div class="content">
                        <h4 >{{$projet->description}}</h4>

                        @if($projet->lien)

                        @if(substr($projet->lien,-4)=='.pdf')

                        <p> Document:
                            <embed class="image is-4by3" src="{{ URL::asset('/') }}doc/faireProjet/{{ $projet->lien }}" scale="tofit" />
                        </p>

                        @elseif(substr($projet->lien,0,4)=='http')

                        <p> Lien: <a href="{{$projet->lien }}">{{$projet->lien }}</a></p>

                        @else

                        <p> Document:
                            <a href="{{ URL::asset('/') }}doc/faireProjet/{{ $projet->lien }}" download>
                            <embed class="image is-4by3 is-inline" src="{{ URL::asset('/') }}doc/faireProjet/{{ $projet->lien }}" scale="tofit" />Télécharger
                            </a>
                        </p>

                        @endif

                        @endif

                        @if($projet->resultat_description && $projet->statut_reussite)
                        <p> Description résultat: {{$projet->resultat_description }}</p>

                        @endif
                        <a href="{{ Route('projetStagiaireModifierResultat',[$projet->id_projet,$projet->id_stagiaire,$projet->id_session])}}" class="button is-link">Modifier le résultat</a>
                        <button  data-target = "#{{$projet->id_projet}}" class="button is-danger modal-button">Supprimer</button>
                        <div id="{{$projet->id_projet}}" class="modal">
                                    <div class="modal-background"></div>
                                    <div class="modal-card">
                                        <header class="modal-card-head">
                                        <p class="modal-card-title">Suppression du projet du stagiaire</p>
                                        <button class="delete" aria-label="close"></button>
                                        </header>
                                        <section class="modal-card-body">
                                            Souhaitez-vous supprimer le projet du stagiaire ?
                                        </section>
                                        <form action="{{ Route('deleteResultProjetStagiaire',[$projet->id_projet,$projet->id_stagiaire,$projet->id_session])}}" method="POST">
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
                    <a href="{{ Route('projetViewStagiaire',$projet->id_projet)}}" class="button is-link mt-1">Voir le Projet</a>
                </div>
                </div>
            </div>
        </div>
      @endforeach
    </div>
    @endif
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
                        <a href="/qcm">
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
