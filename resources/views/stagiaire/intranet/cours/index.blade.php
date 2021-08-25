@extends('layouts.appIntranet')

@section('content')
@if(Auth::user())

        <div class="column is-9">
        @if($SessionTerminée)
        @if($ResultatsessionStagiaire)
        @if($ResultatsessionStagiaire->validation==1)
        <div class="column is-9 notification is-success has-text-centered">
        Félicitations vous avez réussi !
        </div>
        @if($titre)
        <a class = "button is-success button-card modal-button" href="{{Route('viewTitre',$titre->id)}}">Voir le diplôme</a>
        @endif
        @else
        <div class="column is-9 notification is-warning has-text-centered">
        Non validé
        </div>
        @endif
        @else
        <div class="column is-9 notification is-warning has-text-centered">
       Session terminée veuillez attendre le résultat
        </div>
        @endif
        @else
        @if($cours)
        @if (session('warning'))
        <div class="column is-9 notification is-warning has-text-centered ">
        <button class="delete"></button>
            {{ session('warning') }}
        </div>
        @endif
        <div class="content is-medium">
            @foreach($chapitre->chapitre as $chap)
        <h3 class="title is-3">{{$chap->numero_chapitre}}. {{$chap->designation}}</h3>
        <video class="video" width="100%" controls>
            <source src="{{ URL::asset('/') }}video/chapitre/{{$chap->video}}" >
            Votre lecteur ne supporte pas ce type de video
        </video>
            @foreach($chap->section->reverse() as $section)
                <div class="box mt-4">
                    <h4 id="const" class="title is-3 has-text-centered">{{$section->designation}}</h4>
                        <article class="message is-primary">
                            <span class="icon has-text-primary">
                            </span>
                            <div class="message-body">
                            {{$section->contenu}}
                            </div>
                        </article>
                        @if(! empty($section->image))
                            <img class="imageSection" src="{{ URL::asset('/') }}img/section/{{$section->image}}" alt="Placeholder image">
                        @endif
                </div>
            @endforeach
        @endforeach
    </div>
    @else 
        <div class="column is-9 notification is-warning has-text-centered ">
            Vous ne suivez aucune formation
        </div>
    @endif
    @if($qcmCount != 0 && $scoreCount == 0)
    <footer class="buttons paginate" class="mb-4">
        <a href="{{ url('intranet/qcm') }}" class="button is-success sizeButton">Faire le QCM</a>
    </footer>
    @elseif($qcmCount != 0 && $scoreCount == 1)
    <div class="flex alignStart">
        <footer class="buttons paginate" class="mb-4">
            <a href="{{ url('intranet/qcm') }}" class="button is-success sizeButton">Voir mes résultats au QCM</a>
        </footer>
        @endif
        @if($projetCount == 0 && $scoreCount == 1)
        <form action="{{ url('intranet/next') }}" method="POST">
        @csrf
        <footer class="buttons paginate" class="mb-4">
            <button type="submit" class="button is-link sizeButton">Continuer</button>
        </footer>
        </form>
        @endif
        @if($exerciceCount != 0 && $scoreCount == 1)
        <footer class="buttons paginate" class="mb-4">
            <a href="{{ url('intranet/exercice') }}" class="button is-info sizeButton">Accéder aux exercices</a>
        </footer>
        @endif
        @if($projetCount != 0 && $scoreCount == 1)
        <footer class="buttons paginate" class="mb-4">
            <a href="{{ url('intranet/projet') }}" class="button is-link sizeButton">Accéder au projet</a>
        </footer>
        @endif
    </div>
</div>
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