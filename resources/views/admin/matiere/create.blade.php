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
    @if (session('success'))
        <div class="notification is-success has-text-centered my-4">
            {{ session('success') }}
        </div>
    @endif


    <h2 class="title is-2 has-text-centered mt-6">Ajouter une matière </h2>
    <form action="{{ route('matiere.store') }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf

        <div class="form-group hauteur100">
            
            <label class="label">Une matière doit appartenir à une catégorie</label>
            
                <!-- c'est le id="categorie" qui récupère l'information-->
                <div class="control has-icons-left">
                    <div class="select">
                        <div class="control">

                            <select id="categorie_id" name="categorie_id" class="form-control ">
                            <option selected>Sélectionner une catégorie</option>
                            @foreach($categories as $key => $categorie)
                            <option value="{{$key}}"> {{$categorie}}</option>
                            @endforeach
                            </select>

                        </div>
                    </div>
                        <div class="icon is-small is-left">
                            <i class="fa fa-certificate " aria-hidden="true" style=color:#0080FF></i>
                        </div>
                </div> 
        </div>

        <div class="field">
            <label class="label">Nom de la matière</label>
                <div class="control">
                    <input name="designation_matiere" class="input" type="text" placeholder="Nom de la matière">
                </div>
            </div>

            <div class="control mt-4 mb-4">
                <button type="submit" class="button is-fullwidth is-link is-rounded">Créer</button>
            </div>
        </div>
    </form>



    
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
                            <span>Acceuil Acceuil</span>
                        </a>

</button>
@endif
@endsection