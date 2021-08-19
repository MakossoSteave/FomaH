@extends('layouts.appIntranetNeutral')

@section('content')
@if(Auth::user())
      <div class="columns is-multiline">
        @foreach($projets as $projet)
            <div class="column is-4">
            <div class="card is-shady">
                <div class="card-image">
                <img src="{{ URL::asset('/') }}img/projet.jpg" alt="" class="img is-4by3">
                </div>
                <div class="card-content">
                <div class="content">
                    <h4 class="excerpt">{{$projet->description}}</h4>
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