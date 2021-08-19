@extends('layouts.appIntranetNeutral')

@section('content')
@if(Auth::user())
    <div class="column is-9">
        <div class="content is-medium">
            <h1 class="has-text-centered">Live</h1>
            <h2>{{date('d-m-Y H:i', strtotime($sessionLive->date_meeting))}}</h2>
            <a href="{{$sessionLive->lien}}" class="button is-link is-inverted is-large is-fullwidth has-text-black">Accéder au live</a>
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