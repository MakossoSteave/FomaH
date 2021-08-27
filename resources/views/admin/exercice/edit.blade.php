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
    
    <div id="formUpdateExercice">
    <div id="updateExercice">
    <h2 class="title is-2 has-text-centered mt-6">Modifier un exercice</h2>
    @foreach($exercices as $exercice)
    <form action="{{ route('exercice.update', $exercice->id) }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf
        @method('PUT')

        <input type="hidden" name="id_chapitre" value="{{$exercice->id_chapitre}}">

        <div class="field">
            <label class="label">Enonce de l'exercice</label>
                <div class="control">
                    <input name="enonce" class="input" type="text" placeholder="Enonce de l'exercice" value="{{$exercice->enonce}}">
                </div>
        </div>

        <div class="field">
            <label class="label">Ajouter une image</label>
            <div id="file-js-image-exercice" class="file has-name">
                    <label class="file-label">
                        <input class="file-input" type="file" name="image">
                        <span class="file-cta">
                        <span class="file-icon">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="file-label">
                            Choisir une image
                        </span>
                        </span>
                        <span class="file-name">
                            Aucune image
                        </span>
                    </label>
            </div>

                <script>
                const fileInput = document.querySelector('#file-js-image-exercice input[type=file]');
                fileInput.onchange = () => {
                    if (fileInput.files.length > 0) {
                    const fileName = document.querySelector('#file-js-image-exercice .file-name');
                    fileName.textContent = fileInput.files[0].name;
                    }
                }
                </script>
        </div>

            @foreach($exercice->Questions_exercice as $keyQuestion => $question)

            <input type="hidden" name="updateExercice[{{$keyQuestion}}][exerciceID]" value="{{$question->id}}">

            <div class='flex'>
                <div>

                </div>
                <div class='mt-2 mb-2'>
                    <a id="{{$question->id}}" class='has-icons-right has-text-danger deleteUpdateExercice'>
                        Supprimer la question
                        <span class='icon is-small is-right'>
                        <i class='fas fa-trash-alt'></i>
                        </span>
                    </a>
                </div>
            </div>

            <div class="field">
                <label class="label">Question</label>
                    <div class="control">
                        <input name="updateExercice[{{$keyQuestion}}][question]" class="input" type="text" placeholder="Question" value="{{$question->question}}">
                    </div>
            </div>

            @foreach($question->Questions_correction as $correction)

            <input type="hidden" name="updateExercice[{{$keyQuestion}}][correctionID]" value="{{$correction->id}}">

            <div class="field">
                <label class="label">Contenu</label>
                    <div class="control">
                        <textarea name="updateExercice[{{$keyQuestion}}][reponse]" class="textarea" type="text" placeholder="Contenu">{{$correction->reponse}}</textarea>
                    </div>
            </div>

            <div class="field">
                <label class="label">Ajouter une image</label>
                <div id="file-js-image-exo" class="file has-name">
                        <label class="file-label">
                            <input class="file-input" type="file" name="updateExercice[{{$keyQuestion}}][image]">
                            <span class="file-cta">
                            <span class="file-icon">
                                <i class="fas fa-upload"></i>
                            </span>
                            <span class="file-label">
                                Choisir un image
                            </span>
                            </span>
                            <span class="file-name">
                                Aucune image
                            </span>
                        </label>
                </div>

                    <script>
                    const fileInput = document.querySelector('#file-js-image-exo input[type=file]');
                    fileInput.onchange = () => {
                        if (fileInput.files.length > 0) {
                        const fileName = document.querySelector('#file-js-image-exo .file-name');
                        fileName.textContent = fileInput.files[0].name;
                        }
                    }
                    </script>
            </div>
                    @endforeach
                @endforeach
                <div class="field">
                <label class="label">Etat</label>                      
                    <select class="form-select block w-full mt-1"  name="etat">   
                        <option 
                        @if($exercice->etat == 1) value="1"
                        @else value="0"
                        @endif selected>
                        @if($exercice->etat == 1) Activé
                        @else Désactivé
                        @endif
                        </option>
                        <option
                        @if(!$exercice->etat == 1) value="1"
                        @else value="0"
                        @endif>
                        @if(!$exercice->etat == 1) Activé
                        @else Désactivé
                        @endif
                        </option>
                    </select>
            </div>
        @endforeach

            <div id="addExercice"></div>

            <div class="flex">
                <div></div>
                <div class="mt-2 mb-2">
                    <a id="buttonAddExercice" class="has-icons-right has-text-black" onclick="addExercice()">
                        Ajouter un exercice
                        <span class="icon is-small is-right"><i class="fas fa-plus"></i></span>
                    </a>
                </div>
            </div>

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