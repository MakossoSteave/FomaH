@extends('layouts.appIntranetNeutral')

@section('content')
@if(Auth::user())
<div class="column is-9">
    <div class="content is-medium">
        <h1 class="has-text-centered">Live</h1>
@if($sessionLive->statut_id == 3)
    <h2 class="subtitle is-3 has-text-centered">Le live du {{date('d-m-Y à H:i', strtotime($sessionLive->date_meeting))}} est en cours, cliquez sur le lien ci-dessous pour y accéder</h2>
        <a href="{{$sessionLive->lien}}" target="_blank" class="button is-link is-inverted is-large is-fullwidth has-text-black pr-6"><i class="fas fa-link"></i>Accéder au live</a>
@elseif($sessionLive->statut_id == 4)
    <h2 class="has-text-centered">Aucun live n'existe</h2>
@elseif($sessionLive->statut_id == 1)
    <h2 class="subtitle is-3 has-text-centered">Le live commencera le {{date('d-m-Y à H:i', strtotime($sessionLive->date_meeting))}}</h2>
@endif
            <img class="image mt-4" src="{{ URL::asset('/') }}img/live.jpg" alt="liveImage">
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