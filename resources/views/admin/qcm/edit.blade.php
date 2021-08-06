@extends('layouts.app')

@section('content')
@if(Auth::user() && Auth::user()->role_id==1)
<div class="container is-max-desktop">
    @if ($errors->any())
    <div class="notification is-danger">
        <button class="delete"></button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
    </div>
    @endif
    <div id="formUpdateQcm">
    <div id="questionUpdateQcm">
    <h2 class="title is-2 has-text-centered mt-6">Modifier un QCM</h2>
    @foreach($qcm as $qcms)
    <form action="{{ route('qcm.update', $qcms->id) }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{$qcms->id}}">

        <div class="field">
            <label class="label">Titre du QCM</label>
                <div class="control">
                    <input name="designation" class="input" type="text" placeholder="Titre du QCM" value="{{$qcms->designation}}">
                </div>
        </div>

            @foreach($qcms->question_qcm as $keyQuest => $questions)
            <input type="hidden" name="updateQcm[{{$keyQuest}}][questionId]" value="{{$questions->id}}">

            <div class='flex'>
                <div>

                </div>
                <div class='mt-2 mb-2'>
                    <a id="{{$questions->id}}" class='has-icons-right has-text-danger deleteUpdateQuestion'>
                        Supprimer la question
                        <span class='icon is-small is-right'>
                        <i class='fas fa-trash-alt'></i>
                        </span>
                    </a>
                </div>
            </div>

            <div class='field' id='questions'>
                <label class='label'>Question</label>
                <div class='control'>
                    <input name="updateQcm[{{$keyQuest}}][question]" class='input' type='text' placeholder='Question' value="{{$questions->question}}">
                </div>
            </div>
            
            <div class='field' id='explications'>
                <label class='label'>Explication</label>
                <div class='control'>
                    <textarea name='updateExplication[]' class='textarea' type='text' placeholder='Explication'>{{$questions->explication}}</textarea>
                </div>
            </div>
                @foreach($questions->reponse_question_qcm as $key => $reponses)
                    <input type="hidden" name="updateQcm[{{$keyQuest}}][{{$key}}][reponseId]" value="{{$reponses->id}}">

                    <div class='field reponse'>
                        <label class='label'>Réponse</label>
                        <div class='control'>
                            <input name="updateQcm[{{$keyQuest}}][reponse{{$index}}]" class='input' type='text' placeholder='Réponse' value="{{$reponses->reponse}}">
                        </div>
                    </div>
                    <div class='field'>
                        <label class='label'>Choisir la validation de la réponse</label>
                        <div class='control'>
                            <div class='select'>
                                <select name="updateQcm[{{$keyQuest}}][validation{{$index}}]">
                                    <option value='1' {{ ($reponses->validation == true) ?  'selected' : ''}}>Bonne réponse</option>
                                    <option value='0' {{ ($reponses->validation == false) ?  'selected' : ''}}>Mauvaise réponse</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php  if ($index < 3) {
                                $index++;
                            } else {
                                $index = 0;
                            }
                    ?>
                @endforeach
            @endforeach
            <div id="addQuestion"></div>
        
            <div class="flex">
                <div></div>
                <div class="mt-2 mb-2">
                    <a id="buttonAddQuestion" class="has-icons-right has-text-black" onclick="addQuestion()">
                        Ajouter une question
                        <span class="icon is-small is-right"><i class="fas fa-plus"></i></span>
                    </a>
                </div>
            </div>

            <div class="field">
                <label class="label">Choisir le chapitre du QCM</label>
                    <div class="control">
                        <div class="select">
                        <select name="id_chapitre">
                            @foreach ($chapitres as $chapitre)
                                <option value="{{$chapitre->id_chapitre}}" {{ ($chapitre->id_chapitre == $qcms->id_chapitre) ? 'selected' : '' }}>{{$chapitre->designation}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
            </div>
        @endforeach

            <div class="control mt-4 mb-4">
                <button type="submit" class="button is-fullwidth is-link is-rounded">Modifier</button>
            </div>
        </div>
    </form>
    </div>
    </div>  
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