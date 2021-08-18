@extends('layouts.appIntranetNeutral')

@section('content')
@if(Auth::user())
    @if($formationName)
        @if($session->statut_id == 3)
        <div class="column is-9">
            <div class="content is-medium">
                <h1 class="has-text-centered mb-4 is-size-3">{{$formationName->libelle}}</h1>
                <p class="mb-4">{{$formationName->description}}</p>
                    <div class="content" id="sommaire">
                        <ol class="is-upper-roman">
                            @foreach($sommaire as $sommaires)
                            @foreach($sommaires->cours as $cours)
                            <li>{{$cours->designation}}</li>
                            <ol>
                                @foreach($cours->chapitre as $chapitre)
                                <li>{{$chapitre->designation}}</li>
                                @endforeach
                            </ol>
                            @endforeach
                            @endforeach
                        </ol>
                    </div>
            </div>
            @elseif($session->statut_id == 2)
            <p>Non débutée</p>
            @elseif($session->statut_id == 5)
            <p>Terminée</p>
            @endif
            @else 
            <div class="column is-9">
            <div class="notification is-warning has-text-centered my-4">
            Vous ne suivez aucune formation
            </div>
        </div>
                @endif
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