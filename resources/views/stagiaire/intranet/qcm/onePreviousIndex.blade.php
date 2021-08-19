@extends('layouts.appIntranetNeutral')

@section('content')

@if(Auth::user())

<div class="column is-9">
    <div class="content is-medium">
        <h3 class="title is-3">{{$qcm->designation}}</h3>
        @foreach($qcm->question_qcm as $key => $question)
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
                </div>
            </div>
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