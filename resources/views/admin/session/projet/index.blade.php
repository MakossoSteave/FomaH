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
            {{ session('error') }}
        </div>
    @endif
    @if($projets->isEmpty())
        <div class="notification is-warning has-text-centered my-4">
            Aucun projet n'existe pour ce cours
        </div>
    @else

    @foreach ($projets as $projet)

    <div class="card my-6">
        <div class="card-content">
            <div class="media-content">
                <div class="flex">
                    <div>
                        <div class="media">
        
                        <div class="media-content">
                            <div class="flex">
                               
                                <p class="title is-4">{{$projet->description}}</p>
                            </div>
                            <p class="subtitle is-6 mt-2">Cours: {{$projet->Cours}}</p>
                            <p class="subtitle is-6">Statut: {{$projet->statut}}</p>
                            <p class="subtitle is-6">Date début: {{$projet->date_debut}}</p>
                            <p class="subtitle is-6">Date fin: {{$projet-> 	date_fin}}</p>
                            @if(count($projet->document)!=0)
                            <p class="subtitle is-6">Documents:</p>
                            @foreach($projet->document as $document)
                        @if(!empty($document->lien))
                        <div class="media-left mt-2">
                            <embed class="image is-4by3" src="{{ URL::asset('/') }}doc/projet/{{ $document->lien }}" />
                        </div>
                        @endif
                        @endforeach
                        @endif
                        </div>
                    </div>
                   
                    <!-- <div>
                    <p class="subtitle is-4"><span class="subtitle is-6">Créé par</span> {{-- $formateur->prenom --}} {{-- $formateur->nom --}}</p>
                    </div> -->
                </div>
            </div>
        </div>

            <div class="content">
                <div class="flex">
                    <div>
                    </div>
                    <div class="flex-bottom">
                        <form action="{{ route('projet.edit', $projet->id) }}" method="GET">
                            @csrf
                            <input type="hidden" name="id_cours" value="{{request()->route('id')}}">
                            <button type="submit" class="button button-card is-info">Modifier</button>
                        </form>
                            <p>

                            </p>
                            
                    </div>
                </div>
            </div>
    </div>
    </div>
    @endforeach
    {!! $projets->links() !!}
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