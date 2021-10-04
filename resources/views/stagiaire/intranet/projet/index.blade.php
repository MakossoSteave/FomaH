@extends('layouts.appIntranet')

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
        @if (session('warning'))
        <div class="notification is-warning has-text-centered  my-4">
        <button class="delete"></button>
            {{ session('warning') }}
        </div>
      @endif
        @if (session('fail'))
            <div class="notification is-danger has-text-centered my-4">
            <button class="delete"></button>
                {{ session('fail') }}
            </div>
        @endif
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
        @if($sessionProjet->statut_id == 3 || ($sessionProjet->statut_id == 4 && $faireProjet == false))
            <h1 class="has-text-centered">Projet</h1>
            @foreach($projets as $projet)
            <div class="box mt-4 @if($projet->resultat_description && $projet->statut_reussite!==null) {{$projet->statut_reussite==1? 'has-background-success':'has-background-danger'}} @endif">
                    <article class="message is-primary">
                        <span class="icon has-text-primary">
                        </span>
                        <div class="message-body">
                        {{$projet->description}}
                        @if($projet->lien)
                    @if(substr($projet->lien,-4)=='.pdf')
                    <p> Document:  <embed class="image is-4by3" src="{{ URL::asset('/') }}doc/faireProjet/{{ $projet->lien }}" scale="tofit" /></p>
                    @elseif(substr($projet->lien,0,4)=='http')
                    <p> Lien: <a href="{{$projet->lien }}">{{$projet->lien }}</a></p>
                    @else
                    <p> Document:
                        
                    <a href="{{ URL::asset('/') }}doc/faireProjet/{{ $projet->lien}}" download>
                    <embed class="image is-4by3 is-inline" src="{{ URL::asset('/') }}doc/faireProjet/{{$projet->lien}}"/>Télécharger</p>
                    </a>
                    @endif
                    @endif
                        @if($projet->resultat_description && $projet->statut_reussite)
                    <p> Description résultat: {{$projet->resultat_description }}</p>
                    @endif
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
        @if($FaireProjetResult->statut_reussite!==null)
        @if($FaireProjetResult->statut_reussite==1)
        <div class="notification is-success has-text-centered my-4">
        Bravo vous avez réussi
        </div>
        <p>{{$FaireProjetResult->resultat_description}}</p>
        <footer class="buttons paginate" class="mb-4">
        <a href="{{Route('coursSuivant')}}" class="button is-success sizeButton " >Continuer</a>
        </footer>
       
        @else
        <div class="notification is-danger has-text-centered my-4">
        Projet non validé
        </div>
        @endif
        @else
        <div class="notification is-success has-text-centered my-4">
        Nous avons bien reçu votre projet
        </div>
        @endif
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
</section>
@elseif($sessionProjet->statut_id == 4)
    <div class="notification is-info has-text-centered my-4">
        Le projet est terminé depuis le {{date('d-m-Y', strtotime($sessionProjet->date_fin))}}
    </div>
    <footer class="buttons paginate" class="mb-4">
        <a href="{{Route('coursSuivant')}}" class="button is-success sizeButton" >Continuer</a>
        </footer>
</section>
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