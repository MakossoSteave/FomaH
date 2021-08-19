@extends('layouts.appIntranetNeutral')

@section('content')
@if(Auth::user())
      <div class="columns is-multiline">
        @foreach($lessons as $lesson)
            @foreach($lesson[0]->Chapitre as $chapitre)
            <div class="column is-4">
            <div class="card is-shady">
                <div class="card-image">
                <video class="video is-4by3" controls>
                    <source src="{{ URL::asset('/') }}video/chapitre/{{$chapitre->video}}" >
                    Votre lecteur ne supporte pas ce type de video
                </video>
            </div>
                <div class="card-content">
                <div class="content">
                    <h4>{{$chapitre->designation}}</h4>
                        <a href="{{url('intranet/chapitres/'.$chapitre->id_chapitre)}}" class="button is-link modal-button">Voir le cours</a>
                </div>
                </div>
            </div>
            </div>
            @endforeach
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