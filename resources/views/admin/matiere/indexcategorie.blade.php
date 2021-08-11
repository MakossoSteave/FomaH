@extends('layouts.app')

@section('content')
@if(Auth::user() && Auth::user()->role_id==1)




<div class="container is-max-desktop">
    <div class="flex mt-4">
        <p class="control has-icons-right">
            <input class="input" type="search" placeholder="Rechercher..."/>
            <span class="icon is-small is-right"><i class="fas fa-search"></i></span>
        </p>
        <a href="{{ route('addMatiere') }}" class="has-icons-right" id="link-black">
            Ajouter une matière Ajouter une matière
            <span class="icon is-small is-right"><i class="fas fa-plus"></i></span>
        </a>
    </div>
    
    @if (session('success'))
        <div class="notification is-success has-text-centered my-4">
            {{ session('success') }}
        </div>
    @endif

    @if($categories->isEmpty())
        <div class="notification is-warning has-text-centered my-4">
            Aucune categorie n'existe
        </div>
    @else

    
    
    @endif



<h2 class="title is-2 has-text-centered mt-6">Modifier ou supprimer une matière</h2>



<form action="{{ route('listematiere') }}" method="POST" enctype="multipart/form-data" class="mt-6">

        @csrf

        <div class="form-group hauteur100">
            
            <label class="label">Sélectionner une liste de matière suivant leur catégorie</label>
            
                <!-- c'est le id="categorie" qui récupère l'information-->
                <div class="control has-icons-left">
                    <div class="select">
                        <div class="control">

                            <select id="categorie_id" name="categorie_id" class="form-control ">
                            <option selected>Sélectionner une catégorie</option>

                            @foreach($categories as  $categorie)
                            <option value="{{$categorie->id}}"> {{$categorie->designation}}</option>
                            @endforeach

                            </select>

                        </div>
                    </div>
                        <div class="icon is-small is-left">
                            <i class="fa fa-certificate " aria-hidden="true" style=color:#0080FF></i>
                        </div>
                </div> 
        </div>

        <div class="field"></div>
            

            <div class="control mt-4 mb-4">
                <button type="submit" class="button is-fullwidth is-link is-rounded">Sélectionner</button>
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
                            <span>Acceuil</span>
                        </a>

</button>
@endif
@endsection