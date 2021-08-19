@extends('layouts.appIntranet')

@section('content')
@if(Auth::user())
    <div class="column is-9">
    @if (session('warning'))
        <div class="column is-9 notification is-warning has-text-centered ">
        <button class="delete"></button>
            {{ session('warning') }}
        </div>
    @endif
        <div class="content is-medium">
            <h1 class="has-text-centered">Exercice</h1>
            @foreach($exercices as $exercice)
            <div class="box mt-4">
                    <article class="message is-primary">
                        <span class="icon has-text-primary">
                        </span>
                        <div class="message-body">
                        {{$exercice->enonce}}
                        </div>
                    </article>
                    @if(!empty($exercice->image))
                        <img class="imageSection" src="{{ URL::asset('/') }}img/exercice/{{$exercice->image}}" alt="Placeholder image">
                    @endif
            </div>
                @foreach($exercice->questions_exercice as $question)
                <p class="mt-4">{{$question->question}}</p>
                    <button class="button is-link is-outlined correctionShow mb-4" id="{{$question->id}}">Voir la correction</button>
                    <div id="correctionToggle{{$question->id}}" style="display: none;">
                    @foreach($question->questions_correction as $correction)
                        <p>{{$correction->reponse}}</p>
                        @if(!empty($correction->image))
                        <img class="imageSection" src="{{ URL::asset('/') }}img/exercice/{{$correction->image}}" alt="Placeholder image">
                        @endif
                    @endforeach
                    </div>
                @endforeach
            @endforeach
        </div>
        <footer class="buttons paginate" class="mb-4">
            <form action="{{ url('intranet/nextIfExercice') }}" method="POST">
            @csrf

                <button class="button is-success sizeButton">Continuer</button>
            </form>
        </footer>
    </div>
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