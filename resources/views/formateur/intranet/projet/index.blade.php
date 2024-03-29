@extends('layouts.appIntranetFormateur')

@section('content')
@if(Auth::user())
<div class="column is-9">
  <div class="content is-medium">
    <h3 class="has-text-centered mb-4">Les projets en cours</h2>
  </div>

  <section class="hero is-info welcome is-small">
    <div class="hero-body">
      <div class="container">
        <h1 class="title">
          Bonjour {{ Str::ucfirst(Auth::user()->name) }}
        </h1>
        <h2 class="subtitle">
          Il y a --- projet(s) à corriger !
        </h2>
      </div>
    </div>
  </section>
  
  @if($projetList != null)
  <table class="table table-striped" width="100%">
    <thead>
      <tr>
        <th scope="col">Projet</th>
        <th scope="col">Stagiaire</th>
        <th scope="col">Note</th>
        <th scope="col">explication</th>
        <th scope="col">Date de début</th>
        <th scope="col">Date de fin</th>
        <th scope="col">Détails</th>
      </tr>
    </thead>
    <tbody>
      @foreach($projetList as $projet)
      <tr>
        <th scope="row">{{substr($projet['description'], 0, 50)}}</th>
        <td>{{$projet['nom']}}</td>
        <td>{{$projet['statut_reussite']}}</td>
        <td>{{$projet['resultat_description']}}</td>
        <td>{{$projet['date_debut']}}</td>
        <td>{{$projet['date_fin']}}</td>
        <td>
          <form action="{{route('one_projet_formateur', $projet['id'])}}" method="get">
            <input type="hidden" value="{{$projet['nom']}}" name="name">
            <button class="button">Voir</button>
          </form>
          <!-- <a href="{{route('one_projet_formateur', $projet['id'])}}" class="button">Voir</a> -->
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
  <h5 class="has-text-centered">Aucun projet en cours</h2>
    @endif
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