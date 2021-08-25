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

    <div id="formUpdateDocuments">
    <div id="DocumentUpdate">
    <h2 class="title is-2 has-text-centered mt-6">Modifier un projet</h2>
    @foreach ($projets as $projet)
    <form action="{{ route('projet.update', $projet->id) }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf
        @method('PUT')

        <div class="field">
            <label class="label">Descritpion du projet</label>
                <div class="control">
                    <textarea name="description" class="textarea" type="text" placeholder="Descritpion du projet">{{$projet->description}}</textarea>
                </div>
        </div>

        <div class="field">
            <label class="label">Etat</label>                      
                <select class="form-select block w-full mt-1"  name="etat">   
                    <option 
                    @if($projet->etat == 1) value="1"
                    @else value="0"
                    @endif selected>
                    @if($projet->etat == 1) Activé
                    @else Désactivé
                    @endif
                    </option>
                    <option
                    @if(!$projet->etat == 1) value="1"
                    @else value="0"
                    @endif>
                    @if(!$projet->etat == 1) Activé
                    @else Désactivé
                    @endif
                    </option>
                </select>
        </div>

        @foreach ($projet->document as $keyDoc => $document)
        <input type="hidden" name="documentsUpdate[{{$keyDoc}}][documentID]" value="{{$document->id}}">

        <div class='flex'>
            <div>

            </div>
            <div class='mt-2 mb-2'>
                <a id="{{$document->id}}" class='has-icons-right has-text-danger deleteUpdateDocument'>
                    Supprimer le document
                    <span class='icon is-small is-right'>
                    <i class='fas fa-trash-alt'></i>
                    </span>
                </a>
            </div>
        </div>

        <div class="field">
            <label class="label">Nom du document</label>
                <div class="control">
                    <input name="documentsUpdate[{{$keyDoc}}][designation]" class="input" type="text" placeholder="Nom du document" value="{{$document->designation}}">
                </div>
        </div>

        <div class="field">
            <label class="label">Ajouter un document</label>
            <div id="file-js-doc-cours" class="file has-name">
                    <label class="file-label">
                        <input class="file-input" type="file" name="documentsUpdate[{{$keyDoc}}][lien]">
                        <span class="file-cta">
                        <span class="file-icon">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="file-label">
                            Choisir un document
                        </span>
                        </span>
                        <span class="file-name">
                            Aucun document
                        </span>
                    </label>
            </div>

                <script>
                    const fileInput = document.querySelector('#file-js-doc-cours input[type=file]');
                    fileInput.onchange = () => {
                        if (fileInput.files.length > 0) {
                        const fileName = document.querySelector('#file-js-doc-cours .file-name');
                        fileName.textContent = fileInput.files[0].name;
                        }
                    }
                    </script>
            </div>
        @endforeach

        <div id="addDocument"></div>

        <div class="flex">
            <div></div>
            <div class="mt-2 mb-2">
                <a id="buttonAddDocument" class="has-icons-right has-text-black" onclick="addDocument()">
                    Ajouter un document
                    <span class="icon is-small is-right"><i class="fas fa-plus"></i></span>
                </a>
            </div>
        </div>    

            <div class="control mt-4 mb-4">
                <button type="submit" class="button is-fullwidth is-link is-rounded">Modifier</button>
            </div>
        </form>
        </div>
        </div> 
    @endforeach
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