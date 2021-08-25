@extends('layouts.appIntranetNeutral')

@section('content')

@if(Auth::user())

<div class="column is-9">
@if (session('warning'))
        <div class="notification is-warning has-text-centered  my-4">
        <button class="delete"></button>
            {{ session('warning') }}
        </div>
      @endif
    <div class="content is-medium">
    <h1 class="has-text-centered">Projet</h1>
        <div class="box mt-4 @if($projet->resultat_description && $projet->statut_reussite!==null) {{$projet->statut_reussite==1? 'has-background-success':'has-background-danger'}} @endif">
                <article class="message is-primary">
                    <span class="icon has-text-primary">
                    </span>
                    <div class="message-body">
                    {{$projet->description}}
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
                    @if($projet->resultat_description && $projet->statut_reussite)
                    <p> Description résultat: {{$projet->resultat_description }}</p>
                    @endif
                    </div>
                </article>
                @if(!empty($projet->document))
                @foreach($projet->document as $document)
                    <embed class="docSize mt-4" src="{{ URL::asset('/') }}doc/projet/{{$document->lien}}" alt="Placeholder image">
                @endforeach
                @endif
        </div>
    </div>
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