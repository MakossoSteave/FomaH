@extends('layouts.app')

@section('content')
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
    <form action="{{ route('qcm.store') }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf

        @foreach($qcm as $qcms)
        <input type="hidden" name="id" value="$qcms->id">

        <div class="field">
            <label class="label">Titre du QCM</label>
                <div class="control">
                    <input name="designation" class="input" type="text" placeholder="Titre du QCM" value="{{$qcms->designation}}">
                </div>
        </div>

            @foreach($qcms->question_qcm as $questions)
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
                    <input name="updateQcm[{{$questions->id}}][question]" class='input' type='text' placeholder='Question' value="{{$questions->question}}">
                </div>
            </div>
            
            <div class='field' id='explications'>
                <label class='label'>Explication</label>
                <div class='control'>
                    <textarea name='updateExplication[]' class='textarea' type='text' placeholder='Explication'>{{$questions->explication}}</textarea>
                </div>
            </div>
                @foreach($questions->reponse_question_qcm as $reponses)
                    <div class='field reponse'>
                        <label class='label'>Réponse</label>
                        <div class='control'>
                            <input name="updateQcm[{{$qcms->id}}][reponse{{$index}}]" class='input' type='text' placeholder='Réponse' value="{{$reponses->reponse}}">
                        </div>
                    </div>
                    <div class='field'>
                        <label class='label'>Choisir la validation de la réponse</label>
                        <div class='control'>
                            <div class='select'>
                                <select name="updateQcm[{{$qcms->id}}][validation{{$index}}]">
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
                            <option value="{{$chapitre->id_chapitre}}">{{$chapitre->designation}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
        </div>

            <div class="control mt-4 mb-4">
                <button type="submit" class="button is-fullwidth is-link is-rounded">Créer</button>
            </div>
        </div>
    </form>
    </div>
    </div>  
</div>
@endsection