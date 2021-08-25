@extends('layouts.appIntranetNeutral')

@section('content')
@if(Auth::user())
      <div class="columns is-multiline">
      @if (session('warning'))
        <div class="column is-9 notification is-warning has-text-centered">
        <button class="delete"></button>
            {{ session('warning') }}
        </div>
      @endif
        @foreach($projets as $projet)
            <div class="column is-4">
            <div class="card is-shady @if($projet->resultat_description && $projet->statut_reussite!==null) {{$projet->statut_reussite==1? 'has-background-success':'has-background-danger'}} @endif">
                <div class="card-image">
                <img src="{{ URL::asset('/') }}img/projet.jpg" alt="" class="img is-4by3">
                </div>
                <div class="card-content">
                <div class="content">
                    <h4 class="@if($projet->statut_reussite===null) excerpt @endif">{{$projet->description}}</h4>
                    @if($projet->lien)
                    @if(substr($projet->lien,-4)=='.pdf')
                    <p> Document:  <embed class="image is-4by3" src="{{ URL::asset('/') }}doc/faireProjet/{{ $projet->lien }}" scale="tofit" /></p>
                    @elseif(substr($projet->lien,0,4)=='http')
                    <p> Lien: <a href="{{$projet->lien }}">{{$projet->lien }}</a></p>
                    @else
                    <p> Document:
                        
                    <a href="{{ URL::asset('/') }}doc/faireProjet/{{ $projet->lien }}" download>
                    <embed class="image is-4by3 is-inline" src="{{ URL::asset('/') }}doc/faireProjet/{{ $projet->lien }}" scale="tofit" />Télécharger</p>
                    </a>
                    @endif
                    @endif
                    @if($projet->resultat_description && $projet->statut_reussite!==null)
                    <p> Description résultat: {{$projet->resultat_description }}</p>
                    @endif
                    
                        <a href="{{url('intranet/projets/'.$projet->id)}}" class="button is-link modal-button">Voir le Projet</a>
                </div>
                </div>
            </div>
        </div>
      @endforeach
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