@extends('layouts.appIntranetNeutral')

@section('content')
@if(Auth::user())
      <div class="columns is-multiline">
        @foreach($qcms as $qcm)
            @foreach($qcm as $q)
            <div class="column is-4">
            <div class="card is-shady">
                <div class="card-image">
                <img src="{{ URL::asset('/') }}img/quiz.jpg" alt="" class="img is-4by3">
                </div>
                <div class="card-content">
                <div class="content">
                    <h4>{{$q->designation}}</h4>
                    @foreach($q->Score_qcm as $scores)
                        <span class="percentage mb-4">{{$scores->resultat}}% de réussite</span>
                        <progress class="progress is-success" value="{{$scores->resultat}}" max="100"></progress>
                    @endforeach
                        <a href="{{url('intranet/qcms/'.$q->id)}}" class="button is-link modal-button">Voir le QCM</a>
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