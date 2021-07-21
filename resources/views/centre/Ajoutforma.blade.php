@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Acceuil</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('centre.index') }}" title="Go back"> <i
                    class="fas fa-backward "></i> </a>
        </div>
    </div>
</div>
<div class="min-h-screen flex mb-4 row-signup">
    <div class="w-3/5 h-12 row-right">

        <div class="text-dig">
            <p class="w-full text-base sm:text-lg md:text-xl text-center lg:text-2xl xl:text-5xl">
                Gerer de multiple centre de formation
            </p>
            <div class="text-center mb-4 w-3/5">
                <img src="https://cdn.dribbble.com/users/79571/screenshots/5516891/workflow_4x.png">
            </div>
        </div>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="w-2/5  h-12 row-left">
        <div class="text-singup mb-8">
            <h2 class="font-black">
                Nouvelle Formation
            </h2>
        </div>
        <div class="form-signup-dig">
            <div class="w-full max-w-xs">
                <form class="max-w-md mb-4 form-input" action="{{ route('centre.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-grey-darker text-sm font-bold mb-2" for="username">
                            Intitulé de formation
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full h-12 py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline"
                            id="text" type="text" name="libelle" placeholder="nom de la formation">
                    </div>
                    <div class="mb-4">
                        <label class="block text-grey-darker text-sm font-bold mb-2" for="username">
                            Description
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full h-12 py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline"
                            id="text" type="text" name="description" placeholder="description de la formation">
                    </div>
                    <div class="mb-4">
                        <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                            Code de reférence
                        </label>
                        <input
                            class="shadow appearance-none border border rounded h-12 w-full py-2 px-3 text-grey-darker mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="text" name="reference" type="text" placeholder="code ref">
                    </div>
                    <div class="mb-4">
                        <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                            Prix
                        </label>
                        <input
                            class="shadow appearance-none border border rounded w-full h-12 py-2 px-3 text-grey-darker mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="password" name="prix" type="number" placeholder="Prix">
                        <input
                            class="shadow appearance-none border border rounded w-full h-12 py-2 px-3 text-grey-darker mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="ref_user" name="userRef" type="hidden" value="{{Auth::user()->id}}">

                    </div>
                    <div class="mb-4">
                        <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                            Nombre d'heure
                        </label>
                        <input
                            class="shadow appearance-none border border rounded w-full h-12 py-2 px-3 text-grey-darker mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="password" name="volume_horaire" type="number" placeholder="Nombre d'heure">
                    </div>
                    <div class="mb-4">
                        <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                            Nombre de cours
                        </label>
                        <input
                            class="shadow appearance-none border border rounded w-full h-12 py-2 px-3 text-grey-darker mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="password" name="nombre_cours_total" type="number" placeholder="Nombre de cours">
                    </div>
                    <div class="mb-4">
                        <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                            Nombre de chapitre
                        </label>
                        <input
                            class="shadow appearance-none border border rounded w-full h-12 py-2 px-3 text-grey-darker mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="password" name="nombre_chapitre_total" type="number" placeholder="Nombre de chapitre">
                    </div>
                    <!-- <input id="etat" name="etat" type="hidden" value="1"> -->
                    <div class="mb-6">
                        <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                            Categorie
                        </label>
                            <select class="form-select block w-full mt-1"  name="categorie_id">
                                @foreach($categories as $categorie)
                                <option value="{{$categorie->id}}">{{$categorie->designation}}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-indigo-500 text-gray-100 p-4 w-full rounded-full tracking-wide
                                font-semibold font-display focus:outline-none focus:shadow-outline hover:bg-indigo-600
                                shadow-lg">
                            Créer
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

</div>

@endsection