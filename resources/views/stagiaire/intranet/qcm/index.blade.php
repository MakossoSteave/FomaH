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
            @foreach($qcms as $qcm)
            <h1 class="has-text-centered">QCM - {{$qcm->designation}}</h1>
            @endforeach
        @if($score != null)
        <h3 class="has-text-centered">Votre résultat</h2>
        <span class="percentage mb-4">{{$score->resultat}}% de réussite</span>
        <progress class="progress is-success" value="{{$score->resultat}}" max="100"></progress>
        <form action="{{ url('intranet/next') }}" method="POST">
        @csrf

        <input type="hidden" name="id_chapitre" value="{{$formation->id_chapitre_Courant}}">
        <input type="hidden" name="id_cours" value="{{$formation->id_cours}}">
        @foreach($qcms as $qcm)
        <input type="hidden" name="qcm_id" value="{{$qcm->id}}">
            @foreach($qcm->question_qcm->reverse() as $key => $question)
                <div class="box mt-4">
                    <h4 id="const" class="title is-3 has-text-centered">{{$question->question}}</h4>
                        @if(!empty($question->explication))
                        <article class="message is-primary">
                            <span class="icon has-text-primary">
                            </span>
                            <div class="message-body">
                            {{$question->explication}}
                            </div>
                        </article>
                        @endif
                    </div>
                    @foreach($question->reponse_question_qcm as $reponse)
                    <div class="ml-6 mr-6">
                        <table class="table">
                            <tr>
                                <td class="{{ $reponse->validation == 1 ? 'is-selected' : '' }} reponseCss">{{$reponse->reponse}}</td>
                            </tr>
                        </table>
                    </div>
                    @endforeach
            @endforeach
        @endforeach
    </div>
    <div class="buttons paginate">
        <button class="button is-success sizeButton">Continuer</button>
    </div>
    </form>
        @else
        <form action="{{ url('intranet/score') }}" method="POST">
        @csrf

        @foreach($qcms as $qcm)
        <input type="hidden" name="qcm_id" value="{{$qcm->id}}">
        <h3 class="title is-3">{{$qcm->designation}}</h3>
            @foreach($qcm->question_qcm->reverse() as $key => $question)
                <div class="box mt-4">
                    <h4 id="const" class="title is-3 has-text-centered">{{$question->question}}</h4>
                    </div>
                    @foreach($question->reponse_question_qcm as $reponse)
                    <div class="ml-6">
                        {{ Form::radio('reponseNameRadio['.$key.']', $reponse->validation) }}
                        <label for="{{$reponse->reponse}}">{{$reponse->reponse}}</label>
                    </div>
                    @endforeach
            @endforeach
        @endforeach
    </div>
    <div class="buttons paginate">
        <button class="button is-success sizeButton">Confirmer</button>
    </div>
    </form>
    @endif
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