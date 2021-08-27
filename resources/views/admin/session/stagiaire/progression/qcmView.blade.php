@extends('layouts.app')

@section('content')
@if(Auth::user() && (Auth::user()->role_id==1 || Auth::user()->role_id==4))

<div class="container">
    
    @if (session('success'))
        <div class="notification is-success has-text-centered my-4">
            {{ session('success') }}
        </div>
    @endif

    @if($qcm==null))
        <div class="notification is-warning has-text-centered my-4">
            Aucun QCM n'existe pour ce stagiaire
        </div>
    @else

   
    <div class="content is-medium mt-5 mb-3">
        <h3 class="title is-3">{{$qcm->designation}}</h3>
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
                </div>
            </div>
        </div>
    </div>

  
    @endif
</div>

@else
<div class="notification is-danger has-text-centered my-4">
@if(Auth::user() && Auth::user()->role_id!=1)
Vous n'êtes pas autorisé !
@else
Votre session a expiré !
@endif
</div>
<button type="button" class="group bg-white rounded-md text-gray-500 inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                         @if(Auth::user() && Auth::user()->role_id==2)
                        <a href="/centre">
                        @elseif(Auth::user() && Auth::user()->role_id==3)
                        <a href="/stagiaire">
                        @elseif(Auth::user() && Auth::user()->role_id==4)
                        <a href="/formateur">
                        @elseif(Auth::user() && Auth::user()->role_id==5)
                        <a href="/organisme">
                        @else
                        <a href="/">
                        @endif
                        <i class="fas fa-home"></i>
                            <span>Acceuil</span>
                        </a>

</button>
@endif
@endsection
