@extends('layouts.app')

@section('content')
@if(Auth::user())
    <div class="column is-9">
        <div class="content is-medium">
        @if (session('success'))
            <div class="notification is-success has-text-centered my-4">
            <button class="delete"></button>
                {{ session('success') }}
            </div>
        @endif

        @if (session('fail'))
            <div class="notification is-danger has-text-centered my-4">
            <button class="delete"></button>
                {{ session('fail') }}
            </div>
        @endif

        @if($sessionProjet->statut_id == 3)
            <h1 class="has-text-centered">Projet</h1>
            @foreach($projets as $projet)
            <div class="box mt-4">
                    <article class="message is-primary">
                        <span class="icon has-text-primary">
                        </span>
                        <div class="message-body">
                        {{$projet->description}}
                        </div>
                    </article>
                    @if(!empty($projet->document))
                    @foreach($projet->document as $document)
                        <embed class="docSize mt-4" src="{{ URL::asset('/') }}doc/projet/{{$document->lien}}" alt="Placeholder image">
                    @endforeach
                    @endif
            </div>
            @endforeach
        </div>
    <div id="projectShowFileLink" style="display: none;">

        <form action="{{ url('intranet/faireProjet') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="field">
            <label class="label">Ajouter un document</label>
            <div id="file-js-doc-projet" class="file has-name">
                    <label class="file-label">
                        <input class="file-input" type="file" name="lienDocProjet">
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
                const fileInput = document.querySelector('#file-js-doc-projet input[type=file]');
                fileInput.onchange = () => {
                    if (fileInput.files.length > 0) {
                    const fileName = document.querySelector('#file-js-doc-projet .file-name');
                    fileName.textContent = fileInput.files[0].name;
                    }
                }
                </script>
        </div>

        <p>Ou</p>

        <div class="field">
        <label class="label">lien du projet</label>
            <div class="control">
                <input name="lienProjet" class="input" type="text" placeholder="lien du projet">
            </div>
        </div>
        <div class="paginate mt-4">
            <button type="submit" class="button is-success sizeButton">valider</button>
        </div>
        </form>
    </div>
        @if($faireProjet == true)
        <div class="notification is-success has-text-centered my-4">
        Nous avons bien reçu votre projet
        </div>
        @elseif($faireProjet == false)
        <footer class="buttons paginate mb-4">
            <button class="button is-success sizeButton showFileProject" onclick="makeProject()">Soumettre mon projet</button>
            </div>
        </footer>
        @endif
</div>
</div>
</div>
</section>
@elseif($sessionProjet->statut_id == 1)
    <div class="notification is-info has-text-centered my-4">
        Le projet commencera le {{date('d-m-Y', strtotime($sessionProjet->date_debut))}}
    </div>
@elseif($sessionProjet->statut_id == 4)
    <div class="notification is-info has-text-centered my-4">
        Le projet est terminé depuis le {{date('d-m-Y', strtotime($sessionProjet->date_fin))}}
    </div>
@endif
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