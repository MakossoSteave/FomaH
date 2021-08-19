@extends('layouts.appIntranetNeutral')

@section('content')
@if(Auth::user())

<div class="columns is-multiline">
@foreach($exercices as $exercice)
    @if($exercice != null)
    <div class="column is-4">
        <div class="card is-shady">
            @if($exercice->image == null)
            <div class="card-image">
                <img class="image cardImageSize" src="{{ URL::asset('/') }}img/exercice.jpg" >
            </div>
            @else
            <div class="card-image">
                <img class="image cardImageSize" height="50vh" src="{{ URL::asset('/') }}img/exercice/{{$exercice->image}}" >
            </div>
            @endif
                <div class="card-content">
                <div class="content">
                    <h4 class="excerpt">{{$exercice->enonce}}</h4>
                        <a href="{{url('intranet/exercices/'.$exercice->id)}}" class="button is-link modal-button">Voir les exercices</a>
                </div>
                </div>
            </div>
        </div>
        @endif
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