@extends('layouts.appIntranetFormateur')

@section('content')
@if(Auth::user())
<div class="column is-9">
    <div class="content is-medium">
        <h3 class="has-text-centered mb-4">Le projet de {{$_GET['name']}}</h2>
    </div>

    <embed class="embbDetail mb-4" src="{{ URL::asset('/') }}doc/faireProjet/{{$projet['lien']}}" />

    <details>
        <summary>Voir les consignes</summary>
        <div class="hero-body">
            <h2 class="subtitle is-4">
                {{$projet['description']}}
            </h2>
            @foreach($projet['Document'] as $document)
            <embed class="embbDetail mb-4" src="{{ URL::asset('/') }}doc/projet/{{$document['lien']}}" />
            @endforeach
        </div>
    </details>
    @if($projet['statut_reussite'] == null)
    <form action="{{route('grade_project')}}" method="POST">
        @csrf
        <input type="hidden" name="stagiaire_id" value="<?= $projet['id_stagiaire'] ?>">
        <input type="hidden" name="name" value="<?= $_GET['name'] ?>">
        <input type="hidden" name="projet_id" value="<?= $projet['id'] ?>">


        <div class="field">
            <label class="label">La note</label>
            <div class="control">
                <input class="input" type="number" min="0" max="100" name="statut_reussite" placeholder="La note sur 100">
            </div>
        </div>

        <div class="field">
            <label class="label">Le commentaire</label>
            <div class="control">
                <textarea name="resultat_description" class="textarea" placeholder="Commenter la note"></textarea>
            </div>
        </div>

        <div class="field is-grouped">
            <div class="control">
                <button class="button is-link">Confirmer</button>
            </div>
        </div>
    </form>
    @else
    <span class="percentage mt-4 mb-4">{{$projet['statut_reussite']}}% de réussite</span>
    <progress class="progress is-success mt-4" value="{{$projet['statut_reussite']}}" max="100"></progress>
    <p>
        {{$projet['resultat_description']}}
    </p>
    <details class="mt-4">
        <summary>Modifier la note</summary>
        <form action="{{route('grade_project')}}" method="POST">
        @csrf
        <input type="hidden" name="stagiaire_id" value="<?= $projet['id_stagiaire'] ?>">
        <input type="hidden" name="name" value="<?= $_GET['name'] ?>">
        <input type="hidden" name="projet_id" value="<?= $projet['id'] ?>">


        <div class="field">
            <label class="label">La note</label>
            <div class="control">
                <input class="input" type="number" min="0" max="100" name="statut_reussite" placeholder="La note sur 100"  value="{{$projet['statut_reussite']}}">
            </div>
        </div>

        <div class="field">
            <label class="label">Le commentaire</label>
            <div class="control">
                <textarea name="resultat_description" class="textarea" placeholder="Commenter la note">{{$projet['resultat_description']}}</textarea>
            </div>
        </div>

        <div class="field is-grouped">
            <div class="control">
                <button class="button is-link">Confirmer</button>
            </div>
        </div>
    </form>
    </details>
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